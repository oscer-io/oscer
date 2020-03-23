<?php

namespace Bambamboole\LaravelCms\Tests\Unit\Options;

use Bambamboole\LaravelCms\Options\Models\Option;
use Bambamboole\LaravelCms\Options\OptionRepository;
use Bambamboole\LaravelCms\Tests\TestCase;
use Illuminate\Support\Arr;

class OptionRepositoryTest extends TestCase
{
    /** @test */
    public function it_merges_the_values_to_the_fields()
    {
        factory(Option::class)->create([
            'key' => 'pages.front_page',
            'value' => 'a-page-slug',
        ]);

        /** @var OptionRepository $resolver */
        $resolver = $this->app->make(OptionRepository::class);

        $fields = $resolver->getOptionFields();

        $this->assertEquals('a-page-slug', Arr::get($fields, 'pages.front_page.value'));
    }

    /** @test */
    public function it_sets_null_as_default_value()
    {
        /** @var OptionRepository $resolver */
        $resolver = $this->app->make(OptionRepository::class);

        $fields = $resolver->getOptionFields();

        $this->assertNull(Arr::get($fields, 'pages.front_page.value'));
    }
}
