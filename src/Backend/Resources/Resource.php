<?php

namespace Bambamboole\LaravelCms\Backend\Resources;

use Bambamboole\LaravelCms\Backend\Contracts\DisplayableModel;
use Bambamboole\LaravelCms\Backend\Contracts\SavableModel;
use Bambamboole\LaravelCms\Backend\Resources\Fields\Field;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator as ValidatorFactory;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

abstract class Resource implements \JsonSerializable
{
    use ConditionallyLoadsAttributes;

    public static string $model;

    protected DisplayableModel $resourceModel;

    protected Collection $fields;

    protected array $additionalValidationRules = [];

    protected bool $displayShowButtonOnIndex = true;

    protected bool $displayEditButtonOnIndex = true;

    public function __construct(DisplayableModel $resourceModel)
    {
        $this->resourceModel = $resourceModel;
        $this->fields = $this->resolveFields();
    }

    /**
     * This method needs to be implemented by the extending Form.
     * It has to return a Collection of Field instances.
     */
    abstract public function fields(): Collection;

    /**
     * This method resolves all the fields values from the single fields
     * depending on the current resource.
     */
    protected function resolveFields()
    {
        return $this->fields()->map(function (Field $field) {
            $field->value = $field->resolve($this->resourceModel);

            return $field;
        });
    }

    protected function filteredFields(Request $request): Collection
    {
        return $this->fields->filter(function (Field $field) use ($request) {
            return ! $field->shouldBeRemoved($request);
        });
    }

    /**
     * This method returns all validation rules form the fields and merges them
     * with the "additionalValidationRules" for validation beyond fields.
     */
    protected function getValidationRules(Request $request)
    {
        return array_merge(
            $this->filteredFields($request)
                ->reduce(function ($rules, Field $field) use ($request) {
                    $rules[$field->name] = $this->resourceModel->isNew()
                        ? $field->getCreationRules()
                        : $field->getUpdateRules();

                    return $rules;
                }, []),
            $this->additionalValidationRules
        );
    }

    /**
     * This method creates a validator with the rules form the relevant fields.
     */
    protected function createValidator(Request $request): Validator
    {
        $rules = $this->getValidationRules($request);

        return ValidatorFactory::make($request->all(), $rules);
    }

    /**
     * The "save" method is executed when a form will be submitted.
     * It executes the validator and fills the resource with
     * the updated values from the request.
     */
    public function save(Request $request): SavableModel
    {
        $validator = $this->createValidator($request);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->filteredFields($request)
            ->each(function (Field $field) use ($request) {
                $field->fill($this->resourceModel, $request);
            });

        $this->beforeSave($request);

        $this->resourceModel->save();

        return $this->resourceModel;
    }

    /**
     * This method can be used to alter the resource before it will be saved.
     */
    public function beforeSave(Request $request)
    {
        //
    }

    /**
     * If we have a field which has the "filled" validation rule we have to strip null values
     * from the form. this happens on the client side. This method abstracts the logic.
     */
    protected function shouldRemoveNullValues(): bool
    {
        $rules = $this->fields->reduce(function ($result, Field $field) {
            foreach ($field->rules as $rule) {
                $result[] = $rule;
            }

            return $result;
        }, []);

        return in_array('filled', $rules);
    }

    public static function asApiResource(DisplayableModel $model)
    {
        $resource = new static($model);

        return $resource->fields->reduce(function (array $result, Field $field) {
            $result[$field->name] = $field->value;

            return $result;
        }, []);
    }

    public static function asApiResourceCollection($models)
    {
        return new AnonymousResourceCollection($models, static::class);
    }

    public function toArray()
    {
        $data = [
            'fields' => $this->fields,
            'model' => $this->resourceModel,
            'resourceId' => $this->when($this->resourceModel->id, $this->resourceModel->id),
            'displayShowButtonOnIndex' => $this->displayShowButtonOnIndex,
            'displayEditButtonOnIndex' => $this->displayEditButtonOnIndex,
            'removeNullValues' => $this->shouldRemoveNullValues(),
        ];

        return $this->filter($data);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
