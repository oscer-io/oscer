<?php

namespace Oscer\Cms\Core\Commands;

use Faker\Generator;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Oscer\Cms\Core\Models\Menu;
use Oscer\Cms\Core\Models\Option;
use Oscer\Cms\Core\Models\Page;
use Oscer\Cms\Core\Models\Permission;
use Oscer\Cms\Core\Models\Post;
use Oscer\Cms\Core\Models\Role;
use Oscer\Cms\Core\Models\Tag;
use Oscer\Cms\Core\Models\User;
use Symfony\Component\Console\Helper\Table;

class InstallCommand extends Command
{
    protected $signature = 'cms:install {--dev} {--fresh}';

    protected $description = 'Install Oscer';

    protected User $admin;

    protected Generator $faker;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // If --fresh option is enabled the database will be migrated fresh
        $this->option('fresh')
            ? $this->call('migrate:fresh')
            : $this->call('migrate');

        $this->registerCmsServiceProvider();
        $this->comment('Publishing Oscer Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'cms-provider']);

        $this->comment('Publishing Oscer assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'cms-assets']);

        $this->comment('Publishing Oscer configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'cms-config']);

        $this->createAdminUser();
        $this->createRoles();

        $this->callSilent('cms:options:resolve');

        $this->seedDummyContent();

        $this->info('Oscer is installed successfully.');
    }

    /**
     * Register the Cms service provider in the application configuration file.
     * Thanks to laravel/nova for inspiration.
     */
    protected function registerCmsServiceProvider(): void
    {
        if (! file_exists(app_path('Providers/CmsServiceProvider.php'))) {
            $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());

            file_put_contents(config_path('app.php'), str_replace(
                "{$namespace}\\Providers\RouteServiceProvider::class,".PHP_EOL,
                "{$namespace}\\Providers\RouteServiceProvider::class,".PHP_EOL."        {$namespace}\Providers\CmsServiceProvider::class,".PHP_EOL,
                file_get_contents(config_path('app.php'))
            ));
        }
    }

    public function createAdminUser(): void
    {
        // admin user
        if ($this->option('dev')) {
            $admin = User::query()->create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => 'password',
            ]);
            $this->line('User email: <info>admin@admin.com</info>');
            $this->line('Password: <info>password</info>');
        } else {
            $admin = User::query()->create([
                'name' => $this->ask('Name for the first admin user?'),
                'email' => $this->ask('Email for the first admin user?'),
                'password' => $this->secret('Password for the first admin user?'),
            ]);
        }
        $admin->assignRole(Role::SUPER_ADMIN_ROLE);

        $this->admin = $admin;

        $this->comment('Super Admin created:');
    }

    protected function createRoles()
    {
        if (
            $this->option('dev')
            || $this->confirm('Should we create default roles for you?')
        ) {
            $this->comment('Create Roles');
            $roles = collect([
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
            ])
                ->map(function ($role) {
                    return Role::query()
                        ->create(['name' => $role['name']])
                        ->givePermissionTo($role['permissions']);
                })->map(function (Role $role) {
                    return [
                        'name' => $role->name,
                        'permissions' => $role->permissions->pluck('name')->implode(', '),
                    ];
                })->toArray();

            $table = new Table($this->output);
            $table
                ->setHeaders(['role name', 'active permissions'])
                ->setRows($roles)
                ->setStyle('default')
                ->setColumnMaxWidth(1, 150)
                ->render();

            $this->info('Roles created');
        }
    }

    protected function seedDummyContent()
    {
        if (
            $this->option('dev')
            || $this->confirm('Should we seed dummy content for you?')
        ) {
            $this->comment('Register factories');
            $this->faker = app()->make(Generator::class);
            app()->singleton(Factory::class, function ($app) {
                $faker = $app->make(Generator::class);

                return Factory::construct($faker, base_path('vendor/oscer-io/oscer/tests/factories'));
            });

            $this->seedTagsAndPosts();
            $this->seedPages();
            $this->seedOptions();
            $this->seedMenuItems();
        }
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

    protected function seedOptions()
    {
        Option::query()
            ->where('key', 'pages.front_page')
            ->first()
            ->update(['value' => 'front-page']);
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
}
