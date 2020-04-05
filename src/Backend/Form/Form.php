<?php

namespace Bambamboole\LaravelCms\Backend\Form;

use Bambamboole\LaravelCms\Backend\Form\Fields\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator as ValidatorFactory;
use Illuminate\Validation\Validator;

abstract class Form implements \JsonSerializable
{
    protected array $data;

    protected Model $resource;

    protected bool $isCreateForm;

    protected array $missingValues = [];

    protected array $additionalValidationRules = [];

    /**
     * @var Validator
     */
    protected $validator;

    public function __construct(Model $resource)
    {
        $this->setResource($resource);
    }

    public function setResource(Model $resource)
    {
        $this->resource = $resource;

        $this->isCreateForm = $resource->id === null;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getValidator(): Validator
    {
        if (! $this->validator) {
            $rules = $this->getValidationRules();

            $this->validator = ValidatorFactory::make($this->data, $rules);
        }

        return $this->validator;
    }

    protected function getValidationRules()
    {
        return array_merge($this->fields()
            ->reduce(function ($rules, Field $field) {
                $rules[$field->name] = $field->getRules($this->isCreateForm);

                return $rules;
            }, []), $this->additionalValidationRules);
    }

    abstract public function fields(): Collection;

    public function save()
    {
        throw_if($this->validator->fails(), \Exception::class, 'form not valid');

        $data = $this->afterValidation($this->validator->valid());

        if ($this->isCreateForm) {
            $this->resource = $this->resource->newQuery()->create($data);
            $this->afterCreate($this->resource);
        } else {
            $this->resource->update($data);
        }

        return $this->resource;
    }

    protected function afterValidation(array $data): array
    {
        return $data;
    }

    public function afterCreate($resource)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return ['data' => array_merge(
            [
                'fields' => $this->resolveValues($this->filteredFields()),
                'removeNullValues' => $this->removeNullValues(),
            ],
            ! empty($this->missingValues) ? ['missing_values' => $this->missingValues] : []
        )];
    }

    public function resolveValues(Collection $fields)
    {
        return $fields->map(function (Field $field) {
            if ($field->fillValue == false) {
                return $field;
            }
            $field->value = $this->resource[$field->name] ?? '';

            return $field;
        });
    }

    protected function filteredFields(): Collection
    {
        return $this->fields()->filter(function (Field $field) {
            if ($this->isCreateForm === true && $field->hiddenOnCreate === true) {
                return false;
            }
            if ($this->isCreateForm === false && $field->hiddenOnUpdate === true) {
                return false;
            }

            return true;
        });
    }

    protected function removeNullValues()
    {
        $rules = $this->filteredFields()->reduce(function ($result, Field $field) {
            foreach ($field->getRules($this->isCreateForm) as $rule) {
                $result[] = $rule;
            }

            return $result;
        }, []);

        return in_array('filled', $rules);
    }
}
