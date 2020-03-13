<?php

namespace Bambamboole\LaravelCms\Themes;

class DefaultTheme implements Theme
{
    public function getPageTemplate(): string
    {
        return 'cms::pages.show';
    }

    public function getBlogIndexTemplate(): string
    {
        return 'cms::blog.index';
    }

    public function getBlogPostTemplate(): string
    {
        return 'cms::blog.index';
    }
}
