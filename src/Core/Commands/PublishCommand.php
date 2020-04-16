<?php

namespace Bambamboole\LaravelCms\Core\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'cms:publish';

    protected $description = 'Publish all cms resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing cms assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'cms-assets']);

        $this->comment('Publishing cms Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'cms-config']);

        $this->info('Laravel cms was installed successfully.');
    }
}
