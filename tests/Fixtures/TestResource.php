<?php

namespace Oscer\Cms\Tests\Fixtures;

use Illuminate\Support\Collection;
use Oscer\Cms\Backend\Resources\Card;
use Oscer\Cms\Backend\Resources\Fields\TextField;
use Oscer\Cms\Backend\Resources\Resource;

class TestResource extends Resource
{
    public static string $model = TestModel::class;

    public function fields(): Collection
    {
        return collect([
            new Card('test',[
                TextField::make('field-in-card'),
            ]),
            TestField::make('test')
        ]);
    }
}
