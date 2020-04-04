<?php

namespace Bambamboole\LaravelCms\Menus\Models;

use Bambamboole\LaravelCms\Api\Contracts\HasApiEndpoints;
use Bambamboole\LaravelCms\Api\Contracts\HasIndexEndpoint;
use Bambamboole\LaravelCms\Api\Contracts\HasShowEndpoint;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;

class Menu implements HasApiEndpoints, HasIndexEndpoint, HasShowEndpoint
{
    public string $name;

    public array $items;

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public static function all()
    {
        return collect(app(Theme::class)->getMenus())
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

        $menu = new self();
        return $menu
            ->setName($name)
            ->setItems($items);
    }

    public function getEndpoints(): array
    {
        return ['index', 'show'];
    }

    public function executeIndex()
    {
        return ['data' => Menu::all()];
    }

    public function executeShow($identifier)
    {
        return ['data' => Menu::resolve($identifier)];
    }
}
