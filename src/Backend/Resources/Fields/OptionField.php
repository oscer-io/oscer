<?php

namespace Oscer\Cms\Backend\Resources\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OptionField
{
    public static function make(string $key, string $type)
    {
        [$tab, $label] = explode('.', $key);

        $resolveValueCallback = function (Field $field) {
            // We access the value property of the Option model
            return $field->model->value;
        };

        $fillResourceCallback = function (Model $model, Request $request) {
            // We need to replace the "." with an "_" because dot notation acts like array access
            $value = $request->input(Str::replaceFirst('.', '_', $model->key));
            // We Write the value into the value property of the Option model
            $model->value = $value;
        };

        switch ($type) {
            case 'text':
                return TextField::make($key, $label, $resolveValueCallback, $fillResourceCallback);
            default:
                throw new \Exception('unknown field type');
        }
    }
}
