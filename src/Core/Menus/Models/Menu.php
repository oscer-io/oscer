<?php

namespace Bambamboole\LaravelCms\Core\Menus\Models;

use Bambamboole\LaravelCms\Backend\Contracts\DisplayableModel;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;

class Menu implements DisplayableModel
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

    /**
     * @inheritDoc
     */
    public function index()
    {
        return self::all();
    }

    /**
     * @inheritDoc
     */
    public function show(string $identifier)
    {
        return self::resolve($identifier);
    }
}
