<?php

namespace Bambamboole\LaravelCms\Backend\Resources\Fields;

use Bambamboole\LaravelCms\Backend\Contracts\SavableModel;
use Illuminate\Http\Request;

class OptionField
{
    public static function make(string $key, string $type)
    {
        [$tab, $label] = explode('.', $key);

        $resolveValueCallback = function (Field $field) {
            dump($field->resource);

            return $field->resource->value;
        };

        $fillResourceCallback = function (SavableModel $model, Request $request) {
            $value = $request->input($model->key);
            $model->value = $value;
        };

        switch ($type) {
            case 'text':
                return TextField::make($key, $label, $resolveValueCallback, $fillResourceCallback);
            default:
                throw new \Exception('unknow field type');
        }
    }
}
