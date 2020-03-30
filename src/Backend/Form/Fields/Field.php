<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

abstract class Field implements \JsonSerializable
{
    public string $name;

    public string $label;

    public string $component;

    public string $value;

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public static function make(string $name, $label = null)
    {
        return new static($name, $label ?? $name);
    }

    public function jsonSerialize()
    {
        return [
            'component' => $this->component,
            'name' => $this->name,
            'label' => $this->label,
            'value' => $this->value,
        ];
    }
}
