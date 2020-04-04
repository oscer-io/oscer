<?php

namespace Bambamboole\LaravelCms\Backend\Form;

use Bambamboole\LaravelCms\Backend\Form\Fields\Field;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator as ValidatorFactory;
use Illuminate\Validation\Validator;

abstract class Form implements \JsonSerializable
{
    protected array $data;

    protected BaseModel $resource;

    protected bool $isCreateForm;

    protected array $missingValues = [];

    /**
     * @var Validator
     */
    private $validator;

    public function __construct(BaseModel $resource)
    {
        $this->resource = $resource;

        $this->isCreateForm = $resource->id === null;
    }

    public function setData(array $data)
    {
        $this->data = $data;
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

    abstract public function fields(): Collection;

    public function getValidator(): Validator
    {
        if (! $this->validator) {
            $rules = $this->fields()->reduce(function ($rules, Field $field) {
                $rules[$field->name] = $field->getRules($this->isCreateForm);

                return $rules;
            }, []);

            $this->validator = ValidatorFactory::make($this->data, $rules);
        }

        return $this->validator;
    }

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

    public static function create(string $resource, $id = null): self
    {
        $resource = config("cms.resources.{$resource}");

        if ($id === null) {
            return (new $resource())->getForm();
        }

        $resourceInstance = $resource::findOrFail($id);

        return $resourceInstance->getForm();
    }

    public static function createMultiple(string $resource, array $ids): Collection
    {
        $resource = config("cms.resources.{$resource}");

        /** @var Collection $instances */
        $instances = $resource::findMany($ids);

        return $instances->map->getForm();
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return ['data' => array_merge(
            ['fields' => $this->resolveValues($this->fields())],
            ! empty($this->missingValues) ? ['missing_values' => $this->missingValues] : []
        )];
    }
}
