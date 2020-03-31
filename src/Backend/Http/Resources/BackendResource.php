<?php

namespace Bambamboole\LaravelCms\Backend\Http\Resources;

use Bambamboole\LaravelCms\Backend\Form\Fields\Field;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class BackendResource extends JsonResource
{
    public function with($request)
    {
        if ($request->header('x-cms-backend', false) && method_exists($this, 'fields')) {
            return [
                'fields' => $this->resolveValues($this->fields($request), $request),
            ];
        }

        return [];
    }

    public function resolveValues(Collection $fields, $request)
    {
        $values = $this->toArray($request);
        return $fields->map(function (Field $field) use ($values) {
            if ($field->fillValue == false) {
                return $field;
            }
            $field->value = $values[$field->name] ?? '';

            return $field;
        });
    }
}
