<?php

namespace Bambamboole\LaravelCms\Models;

class Menu
{
    public string $name;

    public array $items;

    public function __construct(string $name, array $items)
    {
        $this->name = $name;
        $this->items = $items;
    }

    public static function all()
    {
        return collect(config('cms.menus'))
            ->keys()
            ->map(function (string $name) {
                return self::resolve($name);
            });
    }

    public static function resolve(string $name)
    {
        $items = MenuItem::query()
            ->where('menu', $name)
            ->orderBy('order')
            ->get()
            ->toArray();

        return new self($name, $items);
    }
}
