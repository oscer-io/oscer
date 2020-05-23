<?php

namespace Oscer\Cms\Backend\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Oscer\Cms\Backend\Contracts\ElementContainer;
use Oscer\Cms\Backend\Resources\Fields\Field;

class Card implements \JsonSerializable, ElementContainer
{
    protected string $name;

    public array $fields;

    protected string $width;

    public function __construct(string $name, array $fields = [], string $width = 'full')
    {
        $this->name = $name;
        $this->fields = $this->initializeFields($fields);
        $this->width = $width;
    }

    protected function initializeFields(array $fields)
    {
        return collect($fields)->map(function (Field $field) {
            $field->card = $this->name;

            return $field;
        })->all();
    }

    public function resolve(Model $resourceModel)
    {
        return $this->fields->map->resolve($resourceModel);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'width' => "w-{$this->width}",
        ];
    }

    public function getElements(): Collection
    {
        return collect($this->fields);
    }
}
