<?php

namespace Tests\Unit\Backend\Forms;

use Bambamboole\LaravelCms\Backend\Resources\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Backend\Resources\Resource;
use Bambamboole\LaravelCms\Tests\Fixtures\TestModel;
use Bambamboole\LaravelCms\Tests\Fixtures\TestResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class RemoveNullValuesTest extends TestCase
{
    /** @test */
    public function removeNullValues_is_true_if_a_field_has_a_filled_rule()
    {
        $model = new TestModel();
        // We have to set this that the TestField can execute the property
        $model->test = 'init';
        $resource = new TestTrueResource($model);

        $this->assertTrue(Arr::get($resource->toArray(), 'removeNullValues'));
    }

    /** @test */
    public function removeNullValues_is_false_if_no_field_has_a_filled_rule()
    {
        $model = new TestModel();
        // We have to set this that the TestField can execute the property
        $model->test = 'init';
        $resource = new TestFalseResource($model);

        $this->assertFalse(Arr::get($resource->toArray(), 'removeNullValues'));
    }
}

class TestTrueResource extends Resource
{
    public function fields(): Collection
    {
        return collect([
            TextField::make('test')->rules(['filled']),
        ]);
    }
}
class TestFalseResource extends Resource
{
    public function fields(): Collection
    {
        return collect([
            TextField::make('test')->rules(['required']),
        ]);
    }
}
