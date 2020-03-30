<?php

namespace Bambamboole\LaravelCms\Backend\Http\Resources;

use Bambamboole\LaravelCms\Backend\Form\Fields\Field;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class BackendResource extends JsonResource
{
    public function with($request)
    {
        if (method_exists($this, 'fields')) {
            return [
                'fields' => $this->resolveValues($this->fields()),
            ];
        }
    }

    public function resolveValues(Collection $fields)
    {
        return $fields->map(function (Field $field) {
            $name = $field->name;
            $field->value = $this->$name ?? '';

            return $field;
        });
    }
}
