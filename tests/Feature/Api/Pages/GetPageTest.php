<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Api\Pages;

use Bambamboole\LaravelCms\Publishing\Models\Page;
use Bambamboole\LaravelCms\Tests\ApiTestCase;

class GetPageTest extends ApiTestCase
{
    /** @test */
    public function the_request_needs_to_be_authenticated()
    {
        $response = $this->get('/api/cms/pages/1');

        $response->assertStatus(401);
    }

    /** @test */
    public function a_unknown_id_returns_404()
    {
        $this->login();

        $response = $this->get('/api/cms/pages/1337');

        $response->assertStatus(404);
    }

    /** @test */
    public function paginated_posts_can_be_fetched()
    {
        $page = factory(Page::class)->create();
        $this->login();

        $response = $this->get("/api/cms/pages/{$page->id}");

        $response->assertOk();
        $this->assertJsonSchema('responses/page', $response->getContent());
    }
}
