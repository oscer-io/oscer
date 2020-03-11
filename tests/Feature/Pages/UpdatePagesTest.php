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

        $this->put(route('cms.pages.update', $page), ['name' => 'updated']);
        $this->assertEquals('updated', $page->fresh()->name);
    }

    /** @test */
    public function the_slug_must_be_unique()
    {
        $this->login();
        factory(Page::class)->create(['slug' => 'slug_unique1']);
        $page = factory(Page::class)->create(['slug' => 'slug_unique2']);

        $response = $this->put(route('cms.pages.update', $page), ['slug' => 'slug_unique1']);
        $response->assertSessionHasErrors('slug');
    }

    /** @test */
    public function the_slug_must_be_alphanum_with_dashes()
    {
        $this->login();
        $page = factory(Page::class)->create();

        //no whitespace
        $response = $this->put(route('cms.pages.update', $page), ['slug' => 'a b']);
        $response->assertSessionHasErrors('slug');

        //underscore
        $response = $this->put(route('cms.pages.update', $page), ['slug' => '_']);
        $response->assertSessionHasErrors('slug');

        //special char
        $response = $this->put(route('cms.pages.update', $page), ['slug' => '?']);
        $response->assertSessionHasErrors('slug');

        //alphaNum
        $response = $this->put(route('cms.pages.update', $page), ['slug' => 'aAbBbbbCC']);
        $response->assertSessionHasNoErrors();

        //dash
        $response = $this->put(route('cms.pages.update', $page), ['slug' => '-']);
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function the_slug_cant_be_empty()
    {
        $this->login();
        $page = factory(Page::class)->create();

        $response = $this->put(route('cms.pages.update', $page), ['slug' => '']);
        $response->assertSessionHasErrors('slug');
    }

    /** @test */
    public function the_name_cant_be_empty()
    {
        $this->login();
        $page = factory(Page::class)->create();

        $response = $this->put(route('cms.pages.update', $page), ['name' => '']);
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_page_can_be_deleted()
    {
        $this->login();
        $page = factory(Page::class)->create();

        $response = $this->get(route('cms.pages.show', ['page' => $page]));
        $this->assertEquals(200, $response->status());

        $this->delete(route('cms.pages.delete', $page), []);
        $response = $this->get(route('cms.pages.show', ['page' => $page]));

        $this->assertEquals(404, $response->status());
    }
}
