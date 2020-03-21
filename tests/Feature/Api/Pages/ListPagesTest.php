<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Api\Pages;

use Bambamboole\LaravelCms\Publishing\Models\Page;
use Bambamboole\LaravelCms\Tests\ApiTestCase;

class ListPagesTest extends ApiTestCase
{
    /** @test */
    public function the_request_needs_to_be_authenticated()
    {
        $response = $this->get('/api/cms/pages');

        $response->assertStatus(401);
    }

    /** @test */
    public function paginated_posts_can_be_fetched()
    {
        factory(Page::class,20)->create();

        $this->login();

        $response = $this->get('/api/cms/pages');

        $response->assertOk();
        $this->assertJsonSchema('responses/page-collection', $response->getContent());
    }
}
