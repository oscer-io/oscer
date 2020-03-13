<?php

namespace Bambamboole\LaravelCms\Tests\Feature\Users;

use Bambamboole\LaravelCms\Models\Page;
use Bambamboole\LaravelCms\Tests\TestCase;

class UpdatePagesTest extends TestCase
{
    /** @test */
    public function a_page_can_be_updated()
    {
        $this->login();
        $page = factory(Page::class)->create();

        $this->put(route('cms.backend.pages.update', $page), ['name' => 'updated']);
        $this->assertEquals('updated', $page->fresh()->name);
    }

    /** @test */
    public function the_slug_must_be_unique()
    {
        $this->login();
        factory(Page::class)->create(['slug' => 'slug_unique1']);
        $page = factory(Page::class)->create(['slug' => 'slug_unique2']);

        $response = $this->put(route('cms.backend.pages.update', $page), ['slug' => 'slug_unique1']);
        $response->assertSessionHasErrors('slug');
    }

    /** @test */
    public function the_slug_must_be_alphanum_with_dashes()
    {
        $this->login();
        $page = factory(Page::class)->create();
        $attributes = $page->attributesToArray();

        //no whitespace
        $this->put(route('cms.backend.pages.update', $page), ['slug' => 'a b'])->assertSessionHasErrors('slug');

        //underscore
        $this->put(route('cms.backend.pages.update', $page), ['slug' => '_'])->assertSessionHasErrors('slug');

        //special char
        $this->put(route('cms.backend.pages.update', $page), ['slug' => '?'])->assertSessionHasErrors('slug');

        //alphaNum
        $this->put(route('cms.backend.pages.update', $page), array_merge($attributes, ['slug' => 'aAbBbbbCC']))
            ->assertSessionHasNoErrors();

        //dash
        $this->put(route('cms.backend.pages.update', $page), array_merge($attributes, ['slug' => '-']))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function the_slug_cant_be_empty()
    {
        $this->login();
        $page = factory(Page::class)->create();

        $this->put(route('cms.backend.pages.update', $page), ['slug' => ''])->assertSessionHasErrors('slug');
    }

    /** @test */
    public function the_name_cant_be_empty()
    {
        $this->login();
        $page = factory(Page::class)->create();

        $this->put(route('cms.backend.pages.update', $page), ['name' => ''])->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_page_can_be_deleted()
    {
        $this->login();
        $page = factory(Page::class)->create();

        // First check if the response is 200
        $this->get(route('cms.backend.pages.show', ['page' => $page]))->assertOk();

        // Then delete the page and check the response again
        $this->delete(route('cms.backend.pages.delete', $page), []);
        $this->get(route('cms.backend.pages.show', ['page' => $page]))->assertStatus(404);
    }
}
