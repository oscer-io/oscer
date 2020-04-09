<?php

namespace Bambamboole\LaravelCms\Tests\Unit\Backend\Forms\Fields;

use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Bambamboole\LaravelCms\Tests\Fixtures\TestField;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{
    /** @test */
    public function the_name_can_be_set()
    {
        $field = new TestField('name');

        $this->assertEquals('name', $field->name);
    }

    /** @test */
    public function the_label_can_be_set()
    {
        $field = new TestField('name', 'label');

        $this->assertEquals('label', $field->label);
    }

    /** @test */
    public function the_label_defaults_to_the_capitalized_name()
    {
        $field = new TestField('name');

        $this->assertEquals('Name', $field->label);
    }

    /** @test */
    public function the_default_resolveValueCallback_returns_the_value_based_on_name()
    {
        $resourceMock = \Mockery::spy(FormResource::class);
        // we fill the property name
        $resourceMock->name = 'test';

        $field = new TestField('name');
        $value = $field->resolve($resourceMock, true);

        $this->assertEquals('test', $value);
    }

    /** @test */
    public function the_resolveValueCallback_can_be_set()
    {
        $resourceMock = \Mockery::spy(FormResource::class);
        $callback = function () {
            return 'executed';
        };

        $field = new TestField('name', null, $callback);
        $value = $field->resolve($resourceMock, true);

        $this->assertEquals('executed', $value);
    }

    /** @test */
    public function the_default_fillValueCallback_sets_the_value_based_on_name()
    {
        $field = new TestField('name');
        $requestMock = \Mockery::mock(Request::class)
            ->shouldReceive('input')
            ->with('name')
            ->andReturn('test')->getMock();
        $resourceMock = \Mockery::spy(FormResource::class);

        $field->fill($resourceMock, $requestMock);

        $this->assertEquals('test', $resourceMock->name);
    }

    /** @test */
    public function the_fillValueCallback_can_be_set()
    {
        $callback = function ($resource) {
            $resource->testAttribute = 'filled';
        };
        $field = new TestField('name', null, null, $callback);
        $requestMock = \Mockery::spy(Request::class);
        $resourceMock = \Mockery::spy(FormResource::class);

        $field->fill($resourceMock, $requestMock);

        $this->assertEquals('filled', $resourceMock->testAttribute);
    }
}

