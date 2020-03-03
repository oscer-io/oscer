<?php

namespace Bambamboole\LaravelCms\Commands;

use Bambamboole\LaravelCms\Models\CmsPage;
use Bambamboole\LaravelCms\Models\CmsUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:migrate {email?} {password?} {--fresh : Wipe the database before}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run cms database migrations';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->option('fresh')) {
            $this->call('db:wipe', array_filter([
                '--database' => config('cms.database_connection'),
                '--drop-views' => true,
                '--force' => true,
            ]));
        }

        $shouldCreateNewCmsUser =
            ! Schema::connection(config('cms.database_connection'))->hasTable('cms_users') ||
            ! CmsUser::count();

        $shouldCreateNewCmsPage =
            ! Schema::connection(config('cms.database_connection'))->hasTable('cms_pages') ||
            ! CmsPage::count();

        $this->call('migrate', [
            '--database' => config('cms.database_connection'),
            '--path' => 'vendor/bambamboole/laravel-cms/migrations',
        ]);

        if ($shouldCreateNewCmsUser) {
            $email = $this->argument('email') ?? 'admin@admin.com';
            $password = $this->argument('password') ?? 'password';

            CmsUser::create([
                'name' => 'First user',
                'bio' => 'This is me.',
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->line('');
            $this->line('Laravel cms is ready for use. Enjoy!');
            $this->line('User email: <info>'.$email.'</info>');
            $this->line('Password: <info>'.$password.'</info>');
        }

        if ($shouldCreateNewCmsPage) {
            $user =
            $email = $this->argument('email') ?? 'admin@admin.com';
            $password = $this->argument('password') ?? 'password';

            CmsPage::create([
                'author' => 1,
                'type' => 'page',
                'name' => 'first-page',
                'title' => 'First Page',
                'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. ',
                'excerpt' => 'Lorem ipsum dolor sit amet...',
                'date' => Date::make(now()),
                'status' => 'draft',
                'modified' => Date::make(now()),
            ]);

            $this->line('');
            $this->line('Laravel cms is ready for use. Enjoy!');
            $this->line('User email: <info>'.$email.'</info>');
            $this->line('Password: <info>'.$password.'</info>');
        }
    }
}
