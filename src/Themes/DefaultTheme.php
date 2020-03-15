<?php

namespace Bambamboole\LaravelCms\Themes;

class DefaultTheme implements Theme
{
    public function getPageTemplate(): string
    {
        return 'cms::pages.show';
    }

    public function getPostIndexTemplate(): string
    {
        return 'cms::posts.index';
    }

    public function getPostShowTemplate(): string
    {
        return 'cms::posts.show';
    }
}
