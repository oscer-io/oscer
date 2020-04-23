<?php

namespace Oscer\Cms\Tests\Unit\Backend\Resources;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Oscer\Cms\Backend\Resources\Fields\TextField;
use Oscer\Cms\Backend\Resources\Resource;
use Oscer\Cms\Tests\Fixtures\TestModel;
use Oscer\Cms\Tests\Fixtures\TestResource;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
{
    /**
     * Helper method to get content of a protected property.
     */
    protected function getProtectedProperty($object, string $property)
    {
        $reflectionClass = new \ReflectionClass($object);
        $property = $reflectionClass->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /** @test */
    public function it_can_resolve_its_fields()
    {
        $model = new TestModel();
        $model->test = 'value initially set for test';

        $resource = new TestResource($model);
        $fields = $this->getProtectedProperty($resource, 'fields');

        $this->assertEquals('value initially set for test', $fields[0]->value);
    }

    /** @test */
    public function removeNullValues_is_true_if_a_field_has_a_filled_rule()
    {
        $model = new TestModel();
        $resource = new TestTrueResource($model);

        $this->assertTrue(Arr::get($resource->toArray(), 'removeNullValues'));
    }

    /** @test */
    public function removeNullValues_is_false_if_no_field_has_a_filled_rule()
    {
        $model = new TestModel();
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
