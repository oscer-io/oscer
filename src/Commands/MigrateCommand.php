<?php

namespace Bambamboole\LaravelCms\Commands;

use Bambamboole\LaravelCms\Models\User;
use Illuminate\Console\Command;
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
            ! User::count();

        $this->call('migrate', [
            '--database' => config('cms.database_connection'),
            '--path' => 'vendor/bambamboole/laravel-cms/migrations',
        ]);

        if ($shouldCreateNewCmsUser) {
            $email = $this->argument('email') ?? 'admin@admin.com';
            $password = $this->argument('password') ?? 'password';

            User::create([
                'name' => 'First user',
                'bio' => 'This is me.',
                'email' => $email,
                'password' => $password,
            ]);

            $this->line('');
            $this->line('Laravel cms is ready for use. Enjoy!');
            $this->line('User email: <info>'.$email.'</info>');
            $this->line('Password: <info>'.$password.'</info>');
        }
    }
}
