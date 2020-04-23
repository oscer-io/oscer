<?php

namespace Oscer\Cms\Tests\Fixtures;

use Illuminate\Support\Collection;
use Oscer\Cms\Backend\Resources\Resource;

class TestResource extends Resource
{
    public static string $model = TestModel::class;

    public function fields(): Collection
    {
        return collect([TestField::make('test')]);
    }
}
