<?php

namespace Bambamboole\LaravelCms\Backend\Http\Resources;

use Bambamboole\LaravelCms\Backend\Form\Fields\Field;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class BackendResource extends JsonResource
{
    public function with($request)
    {
        if ($request->header('x-cms-backend', false) && method_exists($this, 'fields')) {
            return [
                'fields' => $this->resolveValues($this->fields($request)),
            ];
        }
        return [];
    }

    public function resolveValues(Collection $fields)
    {
        return $fields->map(function (Field $field) {
            if($field->fillValue == false){
                return $field;
            }
            $name = $field->name;
            $field->value = $this->$name ?? '';

            return $field;
        });
    }
}
