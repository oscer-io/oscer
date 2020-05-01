<?php

namespace Oscer\Cms\Frontend\View\Composers;

use Illuminate\View\View;
use Oscer\Cms\Frontend\Contracts\Theme;

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
