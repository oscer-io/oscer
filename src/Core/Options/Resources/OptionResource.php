<?php

namespace Oscer\Cms\Core\Options\Resources;

use Illuminate\Support\Collection;
use Oscer\Cms\Backend\Resources\Fields\OptionField;
use Oscer\Cms\Backend\Resources\Resource;
use Oscer\Cms\Core\Options\Models\Option;

class OptionResource extends Resource
{
    public static string $model = Option::class;

    public function fields(): Collection
    {
        return collect([OptionField::make($this->resourceModel->key, $this->resourceModel->type)]);
    }
}
