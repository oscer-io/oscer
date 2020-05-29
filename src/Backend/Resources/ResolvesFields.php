<?php

namespace Oscer\Cms\Backend\Resources;

use Illuminate\Database\Eloquent\Model;
use Oscer\Cms\Backend\Contracts\ElementContainer;
use Oscer\Cms\Backend\Resources\Fields\Field;

trait ResolvesFields
{
    protected function resolveFields(array $fields, Model $model, string $view = 'create')
    {
        return collect($fields)->map(function ($element) use ($model, $view) {
            if ($element instanceof ElementContainer) {
                return $element->resolveElements($model);
            }
            if ($element instanceof Field && $this->isVisible($element, $view)) {
                return $element->resolve($model);
            }
        })->all();
    }

    protected function isVisible(Field $field, string $view): bool
    {
        if($view === 'create' && $field->showOnCreate === false){
            return false;
        }
        if($view === 'update' && $field->showOnUpdate === false){
            return false;
        }
        if($view === 'detail' && $field->showOnDetail === false){
            return false;
        }
        if($view === 'index' && $field->showOnIndex === false){
            return false;
        }
        return true;
    }
}
