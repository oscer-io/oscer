<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Backend\Options;

use Bambamboole\LaravelCms\Models\Option;
use Bambamboole\LaravelCms\Tests\TestCase;

class ListOptionsTest extends TestCase
{
    /** @test */
    public function it_merges_the_values_to_the_fields()
    {
        Option::create([
            'key' => 'pages/front_page',
            'value' => 'a-page-slug'
        ]);

        $this->login();
        $response = $this->get('/admin/options');

        $this->assertEquals('a-page-slug', $response->json('pages.front_page.value'));
    }

}
