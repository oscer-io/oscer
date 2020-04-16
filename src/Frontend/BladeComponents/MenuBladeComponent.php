<?php

namespace Bambamboole\LaravelCms\Frontend\BladeComponents;

use Bambamboole\LaravelCms\Core\Menus\Models\Menu;
use Bambamboole\LaravelCms\Frontend\Contracts\Theme;
use Illuminate\View\Component;

class MenuBladeComponent extends Component
{
    protected Theme $theme;

    protected Menu $menu;

    public function __construct(Theme $theme, string $location)
    {
        $this->theme = $theme;
        $this->menu = Menu::query()->firstOrCreate(
            ['location' => $location],
            ['name' => "New menu at location: {$location}", 'location' => $location]);
    }

    public function render()
    {
        return view(
            $this->theme->getMenus()[$this->menu->location]['template'],
            ['menu' => $this->menu]
        );
    }
}
