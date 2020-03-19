<?php

namespace Bambamboole\LaravelCms\Commands\Development;

use Bambamboole\LaravelCms\Models\MenuItem;
use Bambamboole\LaravelCms\Models\Option;
use Bambamboole\LaravelCms\Models\Page;
use Bambamboole\LaravelCms\Models\Post;
use Bambamboole\LaravelCms\Models\Tag;
use Faker\Generator;
use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Collection;

class SeedCommand extends Command
{
    protected $signature = 'cms:dev:seed';

    protected $description = 'Seed CMS with dummy data';

    protected Generator $faker;

    public function handle(Application $app, Generator $faker): void
    {
        $this->faker = $faker;
        // Let Laravel's factory load the factories from this package
        $app->singleton(Factory::class, function ($app) {
            $faker = $app->make(Generator::class);

            return Factory::construct($faker, base_path('vendor/bambamboole/laravel-cms/tests/factories'));
        });

        $this->seedTagsAndPosts();
        $this->seedPages();
        $this->seedMenuItems();
        $this->seedOptions();

        $this->info('Laravel CMS was seeded with dummy data.');
    }

    protected function seedTagsAndPosts()
    {
        $this->comment('Seeding tags');
        $tags = collect(['General', 'Tech', 'PHP', 'Laravel', 'Vue.js', 'Travel'])
            ->map(function ($name) {
                return factory(Tag::class)->create(['name' => $name]);
            });
        $this->info("{$tags->count()} tags seeded");

        $this->comment('Seeding posts');
        $posts = factory(Post::class, 10)->create(['author_id' => 1]);
        $posts->each(function (Post $post) use ($tags) {
            $post->tags()->sync($tags->random(rand(1, 3))->pluck('id'));
        });
        $this->info("{$posts->count()} posts seeded and random tags assigned");
    }

    protected function seedMenuItems()
    {
        $this->comment('Seeding menu items');
        collect([
            [
                'name' => 'About me',
                'menu' => 'main',
                'url' => '/about',
                'order' => 1,
            ],
            [
                'name' => 'Blog',
                'menu' => 'main',
                'url' => '/posts',
                'order' => 2,
            ],
            [
                'name' => 'Legal Notice',
                'menu' => 'footer',
                'url' => '/legal',
                'order' => 1,
            ],
            [
                'name' => 'Privacy',
                'menu' => 'footer',
                'url' => '/privacy',
                'order' => 2,
            ],
        ])->map(function ($data) {
            return factory(MenuItem::class)->create($data);
        })->tap(function (Collection $menuItems) {
            $this->info("{$menuItems->count()} menu items seeded.");
        });
    }

    protected function seedPages()
    {
        $this->comment('Seeding pages');
        collect([
            [
                'name' => 'Home',
                'slug' => 'front-page',
                'body' => 'Welcome to Laravel CMS',
            ],
            [
                'name' => 'About me',
                'slug' => 'about',
                'body' => $this->faker->paragraphs(rand(3, 5), true),
            ],
            [
                'name' => 'Legal Notice',
                'slug' => 'legal',
                'body' => $this->faker->paragraphs(rand(3, 5), true),
            ],
            [
                'name' => 'Privacy',
                'slug' => 'privacy',
                'body' => $this->faker->paragraphs(rand(3, 5), true),
            ],
        ])->each(function ($page) {
            factory(Page::class)->create($page);
        })->tap(function (Collection $pages) {
            $this->info("{$pages->count()} pages seeded");
        });
    }

    protected function seedOptions()
    {
        Option::query()->create(['key' => 'pages.front_page','value' => 'front-page']);
    }
}
