<?php

namespace Bambamboole\LaravelCms\Theming\ViewComposers;

use Illuminate\View\View;
use Bambamboole\LaravelCms\Theming\Contracts\Theme;

class ThemeViewComposer
{
    protected Theme $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function compose(View $view)
    {
        $view->with('theme', $this->theme);
    }
}
