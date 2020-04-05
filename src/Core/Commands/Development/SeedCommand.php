<?php

namespace Bambamboole\LaravelCms\Core\Commands\Development;

use Bambamboole\LaravelCms\Core\Menus\Models\MenuItem;
use Bambamboole\LaravelCms\Core\Options\Models\Option;
use Bambamboole\LaravelCms\Core\Pages\Models\Page;
use Bambamboole\LaravelCms\Core\Posts\Models\Post;
use Bambamboole\LaravelCms\Core\Posts\Models\Tag;
use Bambamboole\LaravelCms\Core\Users\Models\User;
use Bambamboole\LaravelCms\Permissions\Models\Permission;
use Bambamboole\LaravelCms\Permissions\Models\Role;
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

    protected User $admin;

    public function handle(Application $app, Generator $faker): void
    {
        $this->faker = $faker;
        // Let Laravel's factory load the factories from this package
        $app->singleton(Factory::class, function ($app) {
            $faker = $app->make(Generator::class);

            return Factory::construct($faker, base_path('vendor/bambamboole/laravel-cms/tests/factories'));
        });

        // Super Admin
        $this->admin = $this->seedSuperAdmin();
        $this->seedRolesAndPermissions();
        $this->seedUsers();
        $this->seedTagsAndPosts();
        $this->seedPages();
        $this->seedMenuItems();
        $this->seedOptions();

        $this->info('Laravel CMS was seeded with dummy data.');
    }

    protected function seedSuperAdmin()
    {
        $user = User::query()->create([
            'name' => 'First user',
            'bio' => 'This is me.',
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);
        $user->assignRole(Role::SUPER_ADMIN_ROLE);
        $this->comment('Super Admin created:');
        $this->line('User email: <info>admin@admin.com</info>');
        $this->line('Password: <info>password</info>');

        return $user;
    }

    protected function seedRolesAndPermissions($roleAmount = 5)
    {
        $this->comment('Seeding roles with random permissions');

        $roles = factory(Role::class, $roleAmount)->create();

        $roles->each(function (Role $role) {
            $role->givePermissionTo(Permission::all()->random(rand(1, Permission::all()->count())));
        });
        $this->info("{$roleAmount} roles seeded");

        $this->comment('Assigning roles with random permissions');
    }

    protected function seedUsers($userAmount = 10)
    {
        $this->comment('Seeding users');
        $users = factory(User::class, $userAmount)->create();

        $users->each(function (User $user) {
            $user->assignRole(Role::all()->random());
        });

        $this->info("{$userAmount} users seeded");
    }

    protected function seedTagsAndPosts($user)
    {
        $this->comment('Seeding tags');
        $tags = collect(['General', 'Tech', 'PHP', 'Laravel', 'Vue.js', 'Travel'])
            ->map(function ($name) {
                return factory(Tag::class)->create(['name' => $name]);
            });
        $this->info("{$tags->count()} tags seeded");

        $this->comment('Seeding posts');
        $posts = factory(Post::class, 10)->create(['author_id' => $this->admin->id]);
        $posts->each(function (Post $post) use ($tags) {
            $post->tags()->sync($tags->random(rand(1, 3))->pluck('id'));
        });
        $this->info("{$posts->count()} posts seeded and random tags assigned");
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
        ])->map(function ($page) {
            return factory(Page::class)->create(array_merge($page, ['author_id' => $this->admin->id]));
        })->tap(function (Collection $pages) {
            $this->info("{$pages->count()} pages seeded");
        });
    }

    protected function seedMenuItems()
    {
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
        });

        $this->info("{$menuItems->count()} menu items seeded.");
    }

    protected function seedOptions()
    {
        Option::query()->create(['key' => 'pages.front_page', 'value' => 'front-page']);
    }
}
