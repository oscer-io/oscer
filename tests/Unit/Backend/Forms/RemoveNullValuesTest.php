<?php

namespace Tests\Unit\Backend\Forms;

use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Backend\Form\Form;
use Bambamboole\LaravelCms\Core\Models\BaseModel;
use Bambamboole\LaravelCms\Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class RemoveNullValuesTest extends TestCase
{
    /** @test */
    public function removeNullValues_is_true_if_a_field_has_a_filled_rule()
    {
        $form = new TestTrueForm(new TestModel());

        $this->assertTrue(Arr::get($form->toArray(),'data.removeNullValues'));
    }

    /** @test */
    public function removeNullValues_is_false_if_no_field_has_a_filled_rule()
    {
        $form = new TestFalseForm(new TestModel());

        $this->assertFalse(Arr::get($form->toArray(),'data.removeNullValues'));
    }
}

class TestModel extends BaseModel{}

class TestTrueForm extends Form{

    public function fields(): Collection
    {
        return collect([
            TextField::make('test')->rules(['filled'])
        ]);
    }
}
class TestFalseForm extends Form{

    public function fields(): Collection
    {
        return collect([
            TextField::make('test')->rules(['required'])
        ]);
    }
}
