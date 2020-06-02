<?php

namespace Oscer\Cms\Tests\Unit\Backend\Resources;

use Oscer\Cms\Backend\Resources\Fields\Field;
use Oscer\Cms\Tests\Fixtures\TestModel;
use Oscer\Cms\Tests\Fixtures\TestResource;
use Oscer\Cms\Tests\TestCase;

class ResourceIndexTest extends TestCase
{
    /** @test */
    public function index_view_has_only_fields()
    {
        $model = new TestModel();
        // The resource has a first level card which gets filtered out
        $resource = new TestResource($model);

        $result = $resource->prepareForIndex();

        foreach ($result['fields'] as $field) {
            $this->assertInstanceOf(Field::class, $field);
        }
    }
}
