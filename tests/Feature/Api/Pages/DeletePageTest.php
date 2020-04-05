<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Api\Pages;

use Bambamboole\LaravelCms\Core\Pages\Models\Page;
use Bambamboole\LaravelCms\Tests\ApiTestCase;

class DeletePageTest extends ApiTestCase
{
    /** @test */
    public function the_request_needs_to_be_authenticated()
    {
        $response = $this->delete('/api/cms/page/1');

        $response->assertStatus(401);
    }

    /** @test */
    public function a_page_can_be_deleted()
    {
        $page = factory(Page::class)->create();
        $this->login();

        $response = $this->delete("/api/cms/page/{$page->id}");

        $response->assertOk();
        $this->assertEquals(0, Page::query()->count());
    }

    /** @test */
    public function a_unknown_id_returns_404()
    {
        $this->login();

        $response = $this->delete('/api/cms/page/1337');

        $response->assertStatus(404);
    }
}
