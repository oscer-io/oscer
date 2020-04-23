<?php

namespace Oscer\Cms\Core\Options\Resources;

use Oscer\Cms\Backend\Resources\Fields\OptionField;
use Oscer\Cms\Backend\Resources\Resource;
use Oscer\Cms\Core\Options\Models\Option;
use Illuminate\Support\Collection;

class OptionResource extends Resource
{
    public static string $model = Option::class;

    public function fields(): Collection
    {
        return collect([OptionField::make($this->resourceModel->key, $this->resourceModel->type)]);
    }
}
