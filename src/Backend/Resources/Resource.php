<?php

namespace Oscer\Cms\Backend\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator as ValidatorFactory;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Oscer\Cms\Backend\Contracts\Element;
use Oscer\Cms\Backend\Contracts\ElementContainer;
use Oscer\Cms\Backend\Http\Requests\ResourceDetailRequest;
use Oscer\Cms\Backend\Http\Requests\ResourceFormRequest;
use Oscer\Cms\Backend\Http\Requests\ResourceIndexRequest;
use Oscer\Cms\Backend\Resources\Fields\Field;

abstract class Resource implements \JsonSerializable
{
    use ConditionallyLoadsAttributes;

    public static string $model;

    protected Model $resourceModel;

    protected Collection $fields;

    protected array $additionalValidationRules = [];

    protected bool $displayShowButtonOnIndex = true;

    protected bool $displayEditButtonOnIndex = true;

    public function __construct(Model $resourceModel)
    {
        $this->resourceModel = $resourceModel;
        $this->fields = new Collection();
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
        return $this->getFields($this->fields())
            ->map(fn(Field $field) => $field->resolve($this->resourceModel));
    }

    protected function filteredFields(Request $request): Collection
    {
        return $this->resolveFields()->filter(function (Field $field) use ($request) {
            return !$field->shouldBeRemoved($request);
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
                ->reduce(function ($rules, Field $field) {
                    $rules[$field->name] = $this->resourceModel->id === null
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
    public function save(Request $request): Model
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
        $rules = $this->resolveFields()->reduce(function ($result, Field $field) {
            foreach ($field->rules as $rule) {
                $result[] = $rule;
            }

            return $result;
        }, []);

        return in_array('filled', $rules);
    }

    public function labels()
    {
        return [
            'buttons' => [
                'create' => __('cms::resources.buttons.create', ['resource' => class_basename($this->resourceModel)]),
                'edit' => __('cms::resources.buttons.edit', ['resource' => class_basename($this->resourceModel)]),
                'save' => __('cms::resources.buttons.save', ['resource' => class_basename($this->resourceModel)]),
                'cancel' => __('cms::resources.buttons.cancel'),
            ],
            'titles' => [
                'index' => __('cms::resources.titles.index', ['resources' => Str::plural(class_basename($this->resourceModel))]),
                'detail' => __('cms::resources.titles.detail', ['resource' => class_basename($this->resourceModel)]),
                'create' => __('cms::resources.titles.create', ['resource' => class_basename($this->resourceModel)]),
                'update' => __('cms::resources.titles.update', ['resource' => class_basename($this->resourceModel)]),
            ],
            'index' => [
                'search' => __('cms::resources.index.search'),
            ],
        ];
    }

    protected function hasDetailView(): bool
    {
        return true;
    }

    protected function defaultCard()
    {
        return new Card('default', [], 'full');
    }

    protected function cards()
    {
        $rawFields = $this->fields();
        $cards = $rawFields->whereInstanceOf(Card::class);
        if ($rawFields->whereInstanceOf(Field::class)->isNotEmpty()) {
            $cards->prepend($this->defaultCard());
        }

        return $cards;
    }

    protected function getFields(Collection $fields)
    {
        return $fields->map(fn ($element) => $element instanceof ElementContainer
            ? $this->getFields($element->getElements())
            : $element
        )->flatten();
    }

    public function prepareForIndex()
    {
        return [
            'labels' => $this->labels(),
            'fields' => $this->resolveFields(),
        ];
    }

    public function prepareForDetail()
    {
        $data = [
            'labels' => $this->labels(),
            'cards' => $this->cards(),
            'fields' => $this->resolveFields(),
            'model' => $this->resourceModel,
            'resourceId' => $this->when($this->resourceModel->id, $this->resourceModel->id),
            'displayShowButtonOnIndex' => $this->displayShowButtonOnIndex,
            'displayEditButtonOnIndex' => $this->displayEditButtonOnIndex,
            'removeNullValues' => $this->shouldRemoveNullValues(),
            'hasDetailView' => $this->hasDetailView(),
        ];

        return $this->filter($data);
    }

    public function prepareForForm()
    {
        return [];
    }

    public function toArray()
    {
        $data = [
            'labels' => $this->labels(),
            'cards' => $this->cards(),
            'fields' => $this->resolveFields(),
            'model' => $this->resourceModel,
            'resourceId' => $this->when($this->resourceModel->id, $this->resourceModel->id),
            'displayShowButtonOnIndex' => $this->displayShowButtonOnIndex,
            'displayEditButtonOnIndex' => $this->displayEditButtonOnIndex,
            'removeNullValues' => $this->shouldRemoveNullValues(),
            'hasDetailView' => $this->hasDetailView(),
        ];

        return $this->filter($data);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
