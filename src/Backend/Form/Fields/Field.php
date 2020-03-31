<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

abstract class Field implements \JsonSerializable
{
    public string $name;

    public string $label;

    public string $component;

    public string $value;

    public bool $fillValue;

    protected array $with = [];

    public function __construct(string $name, string $label, bool $fillValue)
    {
        $this->name = $name;
        $this->label = $label;
        $this->fillValue = $fillValue;
    }

    public static function make(string $name, ?string $label = null, ?bool $fillValue = true)
    {
        return new static($name, $label ?? ucfirst($name), $fillValue);
    }

    public function doNotFillValue()
    {
        $this->fillValue = false;

        return $this;
    }

    public function jsonSerialize()
    {
        $data = [
            'component' => $this->component,
            'name' => $this->name,
            'label' => $this->label,
            'value' => $this->fillValue ? $this->value : null,
        ];

        collect($this->with)->each(function (string $property) use (&$data) {
            $data[$property] = $this->$property;
        });

        return $data;
    }
}
