<?php

namespace Bambamboole\LaravelCms\Backend\Resources\Fields;

use Bambamboole\LaravelCms\Backend\Contracts\SavableModel;
use Illuminate\Http\Request;

class CheckboxGroupField extends Field
{
    public string $component = 'CheckboxGroupField';

    protected array $fields = [];

    protected array $with = ['fields'];

    public function fields(array $checkboxFields)
    {
        $this->fields = $checkboxFields;

        return $this;
    }

    /**
     * This method fills the resource with the updated value from the Form.
     * Therefore the vue components json string must be decoded
     * first and will be accessible by the resources name.
     */
    public function fill(SavableModel $model, Request $request)
    {
        $request->merge([$this->name => json_decode($request->input($this->name), true)]);

        call_user_func($this->fillResourceCallback, $model, $request);
    }
}
