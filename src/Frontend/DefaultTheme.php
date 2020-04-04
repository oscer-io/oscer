<?php

namespace Bambamboole\LaravelCms\Frontend;

use Bambamboole\LaravelCms\Frontend\Contracts\Theme;

class DefaultTheme implements Theme
{
    public function getMenus(): array
    {
        return [
            'main' => [
                'template' => 'cms::themes.default.menus.main',
            ],
            'footer' => [
                'template' => 'cms::themes.default.menus.footer',
            ],
        ];
    }

    public function getFrontPageTemplate(): string
    {
        return $this->getPageTemplate();
    }

    public function getPageTemplate(): string
    {
        return 'cms::themes.default.pages.show';
    }

    public function getPostIndexTemplate(): string
    {
        return 'cms::themes.default.posts.index';
    }

    public function getPostShowTemplate(): string
    {
        return 'cms::themes.default.posts.show';
    }

    public function getOptions(): array
    {
        return [
            'title_prefix' => [
                'label' => 'Title prefix',
                'type' => 'text',
            ],
        ];
    }
}
