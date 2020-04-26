<?php

namespace Oscer\Cms\Backend\Elements;

use Illuminate\Database\Eloquent\Model;
use Oscer\Cms\Backend\Resources\Fields\Field;

class Card implements \JsonSerializable
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
        return collect($fields)->map(function (Field $field){
           $field->card = $this->name;
           return $field;
        })->all();
    }

    public function resolve(Model $resourceModel)
    {
        return $this->fields->map->resolve($resourceModel);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'width' => "w-{$this->width}",
        ];
    }
}
