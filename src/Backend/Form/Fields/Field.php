<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

abstract class Field implements \JsonSerializable
{
    public string $name;

    public string $label;

    public string $component;

    public $value;

    public bool $fillValue;

    public bool $hiddenOnCreate = false;

    public bool $hiddenOnUpdate = false;

    public array $rules = [];

    public array $rulesOnCreate = [];

    public array $rulesOnUpdate = [];

    protected array $with = [];

    protected $resolveValueCallback = false;

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

    public function doNotShowOnCreate()
    {
        $this->hiddenOnCreate = true;

        return $this;
    }

    public function doNotShowOnUpdate()
    {
        $this->hiddenOnUpdate = true;

        return $this;
    }

    public function addResolveValueCallback(\Closure $callback)
    {
        $this->resolveValueCallback = $callback;

        return $this;
    }

    public function rules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    public function rulesOnCreate(array $rules)
    {
        $this->rulesOnCreate = $rules;

        return $this;
    }

    public function rulesOnUpdate(array $rules)
    {
        $this->rulesOnUpdate = $rules;

        return $this;
    }

    public function getRules(bool $forCreate): array
    {
        if ($forCreate === true && !empty($this->rulesOnCreate)) {
            return $this->rulesOnCreate;
        }
        if ($forCreate === false && !empty($this->rulesOnUpdate)) {
            return $this->rulesOnUpdate;
        }

        return $this->rules;
    }

    protected function resolveValue()
    {
        if($this->resolveValueCallback && $this->resolveValueCallback instanceof \Closure){
            return call_user_func($this->resolveValueCallback, $this->value);
        }else{
            return $this->value;
        }
    }

    public function jsonSerialize()
    {
        $data = [
            'component' => $this->component,
            'name' => $this->name,
            'label' => $this->label,
            'rulesOnCreate' => $this->rulesOnCreate,
            'rulesOnUpdate' => $this->rulesOnUpdate,
            'value' => $this->fillValue ? $this->resolveValue() : null,
            'hiddenOnCreate' => $this->hiddenOnCreate,
        ];

        collect($this->with)->each(function (string $property) use (&$data) {
            $data[$property] = $this->$property;
        });

        return $data;
    }
}
