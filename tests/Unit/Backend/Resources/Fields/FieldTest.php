<?php

namespace Oscer\Cms\Tests\Unit\Backend\Resources\Fields;

use Illuminate\Http\Request;
use Oscer\Cms\Tests\Fixtures\TestField;
use Oscer\Cms\Tests\Fixtures\TestModel;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{
    /** @test */
    public function it_has_a_static_make_method_to_chain_the_methods()
    {
        $field = TestField::make('name');

        $this->assertInstanceOf(TestField::class, $field);
    }

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
        $model = new TestModel();
        // we fill the property name
        $model->name = 'test';

        $field = new TestField('name');
        $value = $field->resolve($model);

        $this->assertEquals('test', $value);
    }

    /** @test */
    public function the_resolveValueCallback_can_be_set()
    {
        $model = new TestModel();
        $callback = function () {
            return 'executed';
        };

        $field = new TestField('name', null, $callback);
        $value = $field->resolve($model);

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
        $model = new TestModel();

        $field->fill($model, $requestMock);

        $this->assertEquals('test', $model->name);
    }

    /** @test */
    public function the_fillValueCallback_can_be_set()
    {
        $callback = function ($resource) {
            $resource->testAttribute = 'filled';
        };
        $field = new TestField('name', null, null, $callback);
        $requestMock = \Mockery::spy(Request::class);
        $model = new TestModel();

        $field->fill($model, $requestMock);

        $this->assertEquals('filled', $model->testAttribute);
    }

    /** @test */
    public function rules_can_be_set()
    {
        $field = TestField::make('name')->rules(['required', 'string']);

        $this->assertEquals(['required', 'string'], $field->rules);
    }

    /** @test */
    public function rules_can_be_set_only_for_update()
    {
        $field = TestField::make('name')->rulesForUpdate(['required', 'string']);

        $this->assertEmpty($field->getCreationRules());
        $this->assertEquals(['required', 'string'], $field->getUpdateRules());
    }

    /** @test */
    public function rules_can_be_set_only_for_create()
    {
        $field = TestField::make('name')->rulesForCreate(['required', 'string']);

        $this->assertEmpty($field->getUpdateRules());
        $this->assertEquals(['required', 'string'], $field->getCreationRules());
    }

    /** @test */
    public function a_field_with_a_filled_rule_will_be_removed_if_request_has_no_value()
    {
        $field = TestField::make('name')->rules(['filled']);
        $model = new TestModel();
        $model->name = 'test';
        $field->resolve($model);
        $requestMock = \Mockery::mock(Request::class)
            ->shouldReceive('input')
            ->with('name')
            ->andReturnNull()
            ->getMock();

        $this->assertTrue($field->shouldBeRemoved($requestMock));
    }
}
