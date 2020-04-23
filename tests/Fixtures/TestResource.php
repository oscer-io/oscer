<?php

namespace Oscer\Cms\Tests\Fixtures;

use Oscer\Cms\Backend\Resources\Resource;
use Illuminate\Support\Collection;

class TestResource extends Resource
{
    public static string $model = TestModel::class;

    public function fields(): Collection
    {
        return collect([TestField::make('test')]);
    }
}
