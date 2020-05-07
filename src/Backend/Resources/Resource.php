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
use Oscer\Cms\Backend\Resources\Fields\Field;

abstract class Resource implements \JsonSerializable
{
    use ConditionallyLoadsAttributes;

    public static string $model;

    public static array $searchColumns = ['id'];

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
        // if this method was not executed
        if ($this->fields->isEmpty()) {
            // temporary variable to get a flat collection of fields
            $fields = new Collection();
            // Iterate over the collection returned by the fields method
            $this->fields()->each(function ($field) use ($fields) {
                // These instances can also be cards
                if ($field instanceof Card) {
                    // if it is a card we need all its fields...
                    foreach ($field->fields as $fieldInCard) {
                        // We need to resolve the values for the fields from the resource model.
                        $fieldInCard->resolve($this->resourceModel);
                        // add them to our temporary collection
                        $fields->add($fieldInCard);
                    }
                } elseif ($field instanceof Field) {
                    // the rest should be field instances...
                    if (! $field->card) {
                        // Assign the default card to all fields without card assignment
                        $field->card = 'default';
                    }
                    $field->resolve($this->resourceModel);
                    // add them to our temporary collection
                    $fields->add($field);
                }
            });

            // We need to resolve the values for the fields from the resource model.
            // The result will be assigned to the fields property of this resource.
            $this->fields = $fields;
        }

        // Return the fields
        return $this->fields;
    }

    protected function filteredFields(Request $request): Collection
    {
        return $this->resolveFields()->filter(function (Field $field) use ($request) {
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
