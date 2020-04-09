<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Closure;
use Illuminate\Http\Request;
use JsonSerializable;

abstract class Field implements JsonSerializable
{
    use HasRules;

    public string $name;

    public string $label;

    public string $component;

    public $value;

    public FormResource $resource;

    protected array $with = [];

    protected Closure $resolveValueCallback;

    protected Closure $fillResourceCallback;


    protected bool $isCreation = true;

    public function __construct(
        string $name,
        string $label,
        ?Closure $resolveValueCallback = null,
        ?Closure $fillResourceCallback = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->resolveValueCallback = $resolveValueCallback ?: function (Field $field) {
            $property = $this->name;
            return $field->resource->$property;
        };

        $this->fillResourceCallback = $fillResourceCallback ?: function (FormResource $resource, Request $request) {
            $property = $this->name;
            $value = $request->input($property);
            $resource->$property = $value;
        };
    }

    public static function make(
        string $name,
        ?string $label = null,
        ?Closure $resolveValueCallback = null,
        ?Closure $fillResourceCallback = null
    )
    {
        return new static($name, $label ?? ucfirst($name), $resolveValueCallback, $fillResourceCallback);
    }

    public function fill(FormResource $resource, Request $request)
    {
        call_user_func($this->fillResourceCallback, $resource, $request);
    }

    public function shouldBeRemoved(Request $request)
    {
        if (in_array('filled', $this->getRules($this->isCreation))
            && $request->input($this->name) === null
        ) {
            return true;
        }
        return false;
    }

    public function resolve(FormResource $resource, bool $isCreation)
    {
        $this->resource = $resource;
        $this->isCreation = $isCreation;

        $this->value = $this->resolveValue();
        return $this->value;
    }

    protected function resolveValue()
    {
        return call_user_func($this->resolveValueCallback, $this);
    }

    public function jsonSerialize()
    {
        $data = [
            'component' => $this->component,
            'name' => $this->name,
            'label' => $this->label,
            'rules' => $this->getRules($this->isCreation),
            'value' => $this->resolveValue(),
        ];

        collect($this->with)->each(function (string $property) use (&$data) {
            $data[$property] = $this->$property;
        });

        return $data;
    }
}
