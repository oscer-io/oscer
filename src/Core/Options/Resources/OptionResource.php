<?php

namespace Bambamboole\LaravelCms\Core\Options\Resources;

use Bambamboole\LaravelCms\Backend\Resources\Fields\OptionField;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Bambamboole\LaravelCms\Core\Options\Models\Option;
use Illuminate\Support\Collection;

class OptionResource extends Resource
{
    public static string $model = Option::class;

    public function fields(): Collection
    {
        return collect([OptionField::make($this->resourceModel->key,$this->resourceModel->type)]);
    }
}
