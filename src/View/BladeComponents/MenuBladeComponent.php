<?php

namespace Bambamboole\LaravelCms\View\BladeComponents;

use Bambamboole\LaravelCms\Models\Menu;
use Bambamboole\LaravelCms\Themes\Theme;
use Illuminate\View\Component;

class MenuBladeComponent extends Component
{
    protected Theme $theme;

    protected Menu $menu;

    public function __construct(Theme $theme, string $name)
    {
        $this->theme = $theme;
        $this->menu = Menu::resolve($name);
    }

    public function render()
    {
        return view(
            $this->theme->getMenus()[$this->menu->name]['template'],
            ['menu' => $this->menu]
        );
    }
}
