<?php

namespace Bambamboole\LaravelCms\Commands\Development;

use Bambamboole\LaravelCms\Models\MenuItem;
use Bambamboole\LaravelCms\Models\Post;
use Bambamboole\LaravelCms\Models\Tag;
use Faker\Generator;
use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Factory;

class SeedCommand extends Command
{
    protected $signature = 'cms:dev:seed';

    protected $description = 'Seed CMS with dummy data';

    public function handle(Application $app): void
    {
        // Let Laravel's factory load the factories from this package
        $app->singleton(Factory::class, function ($app) {
            $faker = $app->make(Generator::class);

            return Factory::construct($faker, base_path('vendor/bambamboole/laravel-cms/tests/factories'));
        });

        $this->comment('Seeding menu items');

        $menuItems = collect([
            [
                'name' => 'About me',
                'menu' => 'main',
                'url' => '/about',
                'order' => 1,
            ],
            [
                'name' => 'Blog',
                'menu' => 'main',
                'url' => '/blog',
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
        });
        $this->info("{$menuItems->count()} menu items seeded.");

        $tags = collect(['General', 'Tech', 'PHP', 'Laravel', 'Vue.js', 'Travel'])
            ->map(function ($name) {
                return factory(Tag::class)->create(['name' => $name]);
            });
        $this->info("{$tags->count()} tags seeded");

        $posts = factory(Post::class, 10)->create(['author_id' => 1]);
        $posts->each(function (Post $post) use ($tags) {
            $post->tags()->sync($tags->random(rand(1, 3))->pluck('id'));
        });
        $this->info("{$posts->count()} posts seeded and random tags assigned");

        $this->info('Laravel CMS was seeded with dummy data.');
    }
}
