<?php

namespace Oscer\Cms\Core\Commands\Development;

use Faker\Generator;
use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Collection;
use Oscer\Cms\Core\Menus\Models\Menu;
use Oscer\Cms\Core\Options\Models\Option;
use Oscer\Cms\Core\Pages\Models\Page;
use Oscer\Cms\Core\Posts\Models\Post;
use Oscer\Cms\Core\Posts\Models\Tag;
use Oscer\Cms\Core\Users\Models\Permission;
use Oscer\Cms\Core\Users\Models\Role;
use Oscer\Cms\Core\Users\Models\User;

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

            return Factory::construct($faker, base_path('vendor/oscer-io/oscer/tests/factories'));
        });

        // Super Admin
        $this->admin = $this->seedSuperAdmin();
        $this->seedRolesAndPermissions();
        $this->seedUsers();
        $this->seedTagsAndPosts();
        $this->seedPages();
        $this->seedMenuItems();
        $this->seedOptions();

        $this->info('Oscer was seeded with dummy data.');
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

    protected function seedRolesAndPermissions()
    {
        $this->comment('Seeding roles & permissions');

        collect([
            [
                'name' => 'admin',
                'permissions' => [
                    Permission::all(),
                ],
            ],
            [
                'name' => 'editor',
                'permissions' => [
                    'posts.*', // all permissions in posts
                    'pages.*', // all permissions in pages
                    'menus.*', // all permissions in menus
                    'options.*', // all permissions in options
                ],
            ],
            [
                'name' => 'publisher',
                'permissions' => [
                    'posts.*', // all permissions in posts
                    'pages.*', // all permissions in pages
                    'menus.*', // all permissions in menus
                ],
            ],
            [
                'name' => 'author',
                'permissions' => [
                    'posts.view',
                    'posts.create',
                    'posts.update',
                    'pages.view',
                    'pages.create',
                    'pages.update',
                ],
            ],
            [
                'name' => 'subscriber',
                'permissions' => [
                    'posts.view',
                    'pages.view',
                ],
            ],
        ])->map(function ($role) {
            return factory(Role::class)->create(['name' => $role['name']])->givePermissionTo($role['permissions']);
        });

        $this->info('Roles seeded');
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

    protected function seedTagsAndPosts()
    {
        $this->comment('Seeding tags');
        $tags = collect(['General', 'Tech', 'PHP', 'Laravel', 'Vue.js', 'Travel'])
            ->map(function ($name) {
                return factory(Tag::class)->create(['name' => $name]);
            });
        $this->info("{$tags->count()} tags seeded");

        $this->comment('Seeding posts');
        $posts = factory(Post::class, 10)->create();
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
                'body' => 'Welcome to Oscer',
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
            factory(Page::class, 50)->create(['author_id' => $this->admin->id]);
            $this->info("{$pages->count()} pages seeded");
        });
    }

    protected function seedMenuItems()
    {
        $this->comment('Seeding menu items');
        $menus = collect([
            [
                'name' => 'Main Menu',
                'location' => 'main',
                'items' => [
                    [
                        'name' => 'About me',
                        'url' => '/about',
                        'order' => 1,
                    ],
                    [
                        'name' => 'Blog',
                        'url' => '/posts',
                        'order' => 2,
                    ],
                ],
            ],
            [
                'name' => 'Footer Menu',
                'location' => 'footer',
                'items' => [
                    [
                        'name' => 'Legal Notice',
                        'url' => '/legal',
                        'order' => 1,
                    ],
                    [
                        'name' => 'Privacy',
                        'url' => '/privacy',
                        'order' => 2,
                    ],
                ],
            ],
        ]);
        $menus->each(function (array $data) {
            /** @var Menu $menu */
            $menu = factory(Menu::class)->create(['name' => $data['name'], 'location' => $data['location']]);
            $menu->items()->createMany($data['items']);
        });

        $this->info("{$menus->count()} menus seeded.");
    }

    protected function seedOptions()
    {
        $this->callSilent('cms:options:resolve');
        Option::query()
            ->where('key', 'pages.front_page')
            ->first()
            ->update(['value' => 'front-page']);
    }
}
