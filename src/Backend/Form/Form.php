<?php

namespace Bambamboole\LaravelCms\Backend\Form;

use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Bambamboole\LaravelCms\Backend\Form\Fields\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator as ValidatorFactory;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

abstract class Form implements \JsonSerializable
{
    protected FormResource $resource;

    protected bool $isCreateForm;

    protected array $additionalValidationRules = [];

    protected Collection $fields;

    public function __construct(FormResource $resource)
    {
        $this->resource = $resource;
        $this->isCreateForm = $resource->isCreation();
        $this->fields = $this->resolve();
    }

    /**
     * This method resolves all the fields values from the single fields
     * depending on the current resource.
     */
    protected function resolve()
    {
        return $this->fields()->map(function (Field $field) {
            $field->value = $field->resolve($this->resource, $this->isCreateForm);

            return $field;
        });
    }

    /**
     * This method needs to be implemented by the extending Form.
     * It has to return a Collection of Field instances.
     */
    abstract public function fields(): Collection;

    /**
     * This method returns all validation rules form the fields and merges them
     * with the "additionalValidationRules" for validation beyond fields
     */
    protected function getValidationRules()
    {
        return array_merge(
            $this->fields->reduce(function ($rules, Field $field) {
                $rules[$field->name] = $field->getRules($this->isCreateForm);

                return $rules;
            }, []),
            $this->additionalValidationRules
        );
    }

    /**
     * This method creates a validator with the rules form the relevant fields.
     */
    protected function createValidator(array $data): Validator
    {
        $rules = $this->getValidationRules();

        return ValidatorFactory::make($data, $rules);
    }

    /**
     * The "save" method is executed when a form will be submitted.
     * It executes the validator and fills the resource with
     * the updated values from the request.
     */
    public function save(Request $request): FormResource
    {
        $validator = $this->createValidator($request->all());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->fields()
            ->filter(function (Field $field) use ($request) {
                return !$field->shouldBeRemoved($request);
            })
            ->each(function (Field $field) use ($request) {
                $field->fill($this->resource, $request);
            });

        $this->beforeSave($request);

        $this->resource->save();

        return $this->resource;
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
            foreach ($field->getRules($this->isCreateForm) as $rule) {
                $result[] = $rule;
            }

            return $result;
        }, []);

        return in_array('filled', $rules);
    }

    public function toArray()
    {
        return [
            'fields' => $this->fields,
            'removeNullValues' => $this->shouldRemoveNullValues(),
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
