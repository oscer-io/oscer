<?php

namespace Bambamboole\LaravelCms\Tests\Unit\Services;

use Bambamboole\LaravelCms\Options\Models\Option;
use Bambamboole\LaravelCms\Options\OptionFieldsResolver;
use Bambamboole\LaravelCms\Tests\TestCase;
use Illuminate\Support\Arr;

class OptionFieldsResolverTest extends TestCase
{
    /** @test */
    public function it_merges_the_values_to_the_fields()
    {
        factory(Option::class)->create([
            'key' => 'pages.front_page',
            'value' => 'a-page-slug',
        ]);

        /** @var OptionFieldsResolver $resolver */
        $resolver = $this->app->make(OptionFieldsResolver::class);

        $fields = $resolver->getOptionFields();

        $this->assertEquals('a-page-slug', Arr::get($fields, 'pages.front_page.value'));
    }

    /** @test */
    public function it_sets_null_as_default_value()
    {
        /** @var OptionFieldsResolver $resolver */
        $resolver = $this->app->make(OptionFieldsResolver::class);

        $fields = $resolver->getOptionFields();

        $this->assertNull(Arr::get($fields, 'pages.front_page.value'));
    }
}
