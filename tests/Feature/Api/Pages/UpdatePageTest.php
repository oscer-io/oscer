<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Api\Pages;

use Bambamboole\LaravelCms\Publishing\Models\Page;
use Bambamboole\LaravelCms\Tests\ApiTestCase;

class UpdatePageTest extends ApiTestCase
{
    /** @test */
    public function the_request_needs_to_be_authenticated()
    {
        $response = $this->patch('/api/cms/page/1');

        $response->assertStatus(401);
    }

    /** @test */
    public function a_unknown_id_returns_404()
    {
        $this->login();

        $response = $this->patch('/api/cms/page/1337', ['name' => 'updated_name']);

        $response->assertStatus(404);
    }

    /** @test */
    public function a_page_can_be_updated()
    {
        $page = factory(Page::class)->create();
        $this->login();

        $response = $this->patch("/api/cms/page/{$page->id}", factory(Page::class)->raw(['name' => 'updated_name']));

        $response->assertOk();
        $this->assertEquals('updated_name', $page->fresh()->name);
        $this->assertJsonSchema('responses/page', $response->getContent());
    }

    /**
     * @test
     * @dataProvider invalidData
     */
    public function data_needs_to_be_valid(string $errorKey, array $overrides)
    {
        $this->withoutExceptionHandling();
        $page = factory(Page::class)->create();
        $this->login();
        $response = $this->patch("/api/cms/page/{$page->id}", factory(Page::class)->raw($overrides));
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($errorKey);
    }

    public function invalidData()
    {
        return [
            ['name', ['name' => '']],
        ];
    }
}
