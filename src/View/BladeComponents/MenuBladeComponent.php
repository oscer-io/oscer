<?php

namespace Bambamboole\LaravelCms\View\BladeComponents;

use Bambamboole\LaravelCms\Themes\Theme;
use Illuminate\View\Component;

class MenuBladeComponent extends Component
{
    protected Theme $theme;

    protected string $name;

    public function __construct(Theme $theme, string $name)
    {
        $this->theme = $theme;
        $this->name = $name;
    }

    public function render()
    {
        return view($this->theme->getMenus()[$this->name]['template']);
    }
}
