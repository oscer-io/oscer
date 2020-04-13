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

    public bool $active = true;

    public array $dependency = [];

    public string $component;

    public $value;

    public FormResource $resource;

    protected array $with = [];

    protected Closure $resolveValueCallback;

    protected Closure $fillResourceCallback;

    protected bool $isCreation = true;

    public function __construct(
        string $name,
        ?string $label = null,
        ?Closure $resolveValueCallback = null,
        ?Closure $fillResourceCallback = null
    ) {
        $this->name = $name;
        $this->label = $label ?: ucfirst($name);
        $this->resolveValueCallback = $resolveValueCallback ?: function (self $field) {
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
    ) {
        return new static($name, $label, $resolveValueCallback, $fillResourceCallback);
    }

    /**
     * This method is called when a form will be instantiated. It sets
     * the resource on the field as well as the info if it is a
     * create or update form.
     */
    public function resolve(FormResource $resource, bool $isCreation)
    {
        $this->resource = $resource;
        $this->isCreation = $isCreation;

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
    public function fill(FormResource $resource, Request $request)
    {
        call_user_func($this->fillResourceCallback, $resource, $request);
    }

    /**
     * We use this to check if a field should be removed from the submit process
     * based on the request. If a field has a "filled" rule and is not
     * present In the request we determine is must be removed.
     * Moreover if the current field has a dependency but is
     * not present (not activated in the view), we
     * determine is must be removed as well.
     */
    public function shouldBeRemoved(Request $request)
    {
        if ($request->input($this->name) === null) {
            if ($this->hasDependency() && ($dependency = $request->input($this->dependency['field']))) {
                //check whether this field is active & therefore must be validated or should be skipped
                return ! $this->isDependencyMatched($dependency);
            }

            if (in_array('filled', $this->getRules($this->isCreation))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check whether the current field has a dependency
     */
    public function hasDependency()
    {
        return !empty($this->dependency);
    }

    /**
     * Check whether the given $value matches the value that has been set in the dependency
     */
    protected function isDependencyMatched(string $value)
    {
        $dependency = $this->dependency['value'] ?? null;
        return $value === $dependency;
    }

    public function jsonSerialize()
    {
        $data = [
            'component' => $this->component,
            'name' => $this->name,
            'label' => $this->label,
            'rules' => $this->getRules($this->isCreation),
            'value' => $this->resolveValue(),
            'active' => $this->active,
            'dependency' => $this->dependency,
        ];

        collect($this->with)->each(function (string $property) use (&$data) {
            $data[$property] = $this->$property;
        });

        return $data;
    }

    /**
     * Set the fields initial active state to false. This is useful when using field dependencies.
     */
    public function disable()
    {
        $this->active = false;

        return $this;
    }

    /**
     * Set a dependency to another field. Whenever the dependency field value changes
     * it will be checked against $value. If both match this field will be
     * shown, else it will be hidden. $value can be omitted, this
     * fields name will be used instead.
     */
    public function dependsOn(string $field, ?string $value = null)
    {
        $this->dependency = [
            'field' => $field,
            'value' => $value ?? $this->name,
        ];

        return $this;
    }
}
