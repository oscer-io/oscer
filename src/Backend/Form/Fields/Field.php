<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

use Bambamboole\LaravelCms\Backend\Contracts\DisplayableModel;
use Bambamboole\LaravelCms\Backend\Contracts\SavableModel;
use Closure;
use Illuminate\Http\Request;
use JsonSerializable;

abstract class Field implements JsonSerializable
{
    public string $name;

    public string $label;

    public string $component;

    public $value;

    public array $rules = [];

    protected array $rulesForCreate = [];

    protected array $rulesForUpdate = [];

    public DisplayableModel $resource;

    protected array $with = [];

    protected Closure $resolveValueCallback;

    protected Closure $fillResourceCallback;

    protected bool $showOnIndex = true;

    public function __construct(
        string $name,
        ?string $label = null,
        ?Closure $resolveValueCallback = null,
        ?Closure $fillResourceCallback = null)
    {
        $this->name = $name;
        $this->label = $label ?: ucfirst($name);
        $this->resolveValueCallback = $resolveValueCallback ?: function (self $field) {
            $property = $this->name;

            return $field->resource->$property;
        };

        $this->fillResourceCallback = $fillResourceCallback ?: function (SavableModel $model, Request $request) {
            $property = $this->name;
            $value = $request->input($property);
            $model->$property = $value;
        };
    }

    /**
     * Returns a new field which is chainable.
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * This method is called when a form will be instantiated. It sets
     * the resource on the field as well as the info if it is a
     * create or update form.
     */
    public function resolve(DisplayableModel $resource)
    {
        $this->resource = $resource;

        $this->value = $this->resolveValue();

        return $this->value;
    }

    /**
     * This method resolves the fields value depending on the "resolveValueCallback".
     */
    protected function resolveValue()
    {
        return call_user_func($this->resolveValueCallback, $this);
    }

    /**
     * This method fills the resource with the updated value from the Form.
     */
    public function fill(SavableModel $model, Request $request)
    {
        call_user_func($this->fillResourceCallback, $model, $request);
    }

    /**
     * Define the validation rules.
     */
    public function rules(array $rules)
    {
        $this->rules = $rules;

        return $this;
    }

    public function rulesForCreate(array $rules)
    {
        $this->rulesForCreate = $rules;

        return $this;
    }

    public function rulesForUpdate(array $rules)
    {
        $this->rulesForUpdate = $rules;

        return $this;
    }

    public function getCreationRules(): array
    {
        return array_merge($this->rules, $this->rulesForCreate);
    }

    public function getUpdateRules(): array
    {
        return array_merge($this->rules, $this->rulesForUpdate);
    }

    public function hideOnIndex()
    {
        $this->showOnIndex = false;

        return $this;
    }

    /**
     * We use this to check if a field should be removed from the submit process
     * based on the request. If a field has a "filled" rule and is not
     * present In the request we determine is must be removed.
     */
    public function shouldBeRemoved(Request $request)
    {
        if (in_array('filled', $this->rules)
            && $request->input($this->name) === null
        ) {
            return true;
        }

        return false;
    }

    public function jsonSerialize()
    {
        $data = [
            'component' => $this->component,
            'name' => $this->name,
            'label' => $this->label,
            'value' => $this->resolveValue(),
            'showOnIndex' => $this->showOnIndex,
        ];

        collect($this->with)->each(function (string $property) use (&$data) {
            $data[$property] = $this->$property;
        });

        return $data;
    }
}
