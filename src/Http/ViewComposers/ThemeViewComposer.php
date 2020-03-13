<?php

namespace Bambamboole\LaravelCms\Http\ViewComposers;

use Bambamboole\LaravelCms\Themes\Theme;
use Illuminate\View\View;

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
