<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Api\Pages;

use Bambamboole\LaravelCms\Publishing\Models\Page;
use Bambamboole\LaravelCms\Tests\ApiTestCase;

class CreatePageTest extends ApiTestCase
{
    /** @test */
    public function the_request_needs_to_be_authenticated()
    {
        $response = $this->post('/api/cms/pages');

        $response->assertStatus(401);
    }

    /** @test */
    public function a_post_can_be_created()
    {
        $this->login();

        $response = $this->post('/api/cms/pages', factory(Page::class)->raw());

        $response->assertStatus(201);
        $this->assertJsonSchema('responses/page', $response->getContent());
    }

    /**
     * @test
     * @dataProvider invalidData
     */
    public function data_needs_to_be_valid(string  $errorKey, array $overrides)
    {
        $this->login();

        $response = $this->post('/api/cms/pages', factory(Page::class)->raw($overrides));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($errorKey);
    }

    public function invalidData()
    {
        return [
          ['name', ['name' => '']],
          ['slug', ['slug' => '']],
        ];
    }
}
