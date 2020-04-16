<?php

namespace Bambamboole\LaravelCms\Core\Commands;

use Bambamboole\LaravelCms\Core\Options\Models\Option;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;
use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ResolveOptionsCommand extends Command
{
    protected $signature = 'cms:options:resolve';

    protected $description = 'Resolve all options from the configuration and the theme';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(Theme $theme, Repository $config)
    {
        $resolvedOptions = new Collection();
        $tabsWithOptions = collect(array_merge(
            $config->get('cms.options'),
            ['theme' => $theme->getOptions()]
        ));
        $tabsWithOptions->each(function (array $options, string $tab) use ($resolvedOptions) {
            foreach ($options as $key => $specification) {
                $resolvedOptions->add(Option::query()->updateOrCreate(['key' => "{$tab}.{$key}"], [
                    'key' => "{$tab}.{$key}",
                    'type' => $specification['type'],
                    'label' => isset($specification['label']) ? $specification['label'] : null,
                ]));
            }
        });

        /** @var Collection $resolvedOptionKeys */
        $resolvedOptionKeys = $resolvedOptions->map->key;

        if ($resolvedOptions->count() < Option::query()->count()) {
            Option::all()->filter(function (Option $option) use ($resolvedOptionKeys) {
                return ! $resolvedOptionKeys->contains($option->key);
            })->each->delete();
        }
    }
}
