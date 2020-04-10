<?php

namespace Tests\Unit\Backend\Forms;

use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Tests\Fixtures\TestCreateResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class RemoveNullValuesTest extends TestCase
{
    /** @test */
    public function removeNullValues_is_true_if_a_field_has_a_filled_rule()
    {
        $resource = new TestCreateResource();
        // We have to set this that the TestField can execute the property
        $resource->test = 'init';
        $form = new TestTrueForm($resource);

        $this->assertTrue(Arr::get($form->toArray(), 'removeNullValues'));
    }

    /** @test */
    public function removeNullValues_is_false_if_no_field_has_a_filled_rule()
    {
        $resource = new TestCreateResource();
        // We have to set this that the TestField can execute the property
        $resource->test = 'init';
        $form = new TestFalseForm($resource);

        $this->assertFalse(Arr::get($form->toArray(), 'removeNullValues'));
    }
}

class TestTrueForm extends Form
{
    public function fields(): Collection
    {
        return collect([
            TextField::make('test')->rules(['filled']),
        ]);
    }
}
class TestFalseForm extends Form
{
    public function fields(): Collection
    {
        return collect([
            TextField::make('test')->rules(['required']),
        ]);
    }
}
