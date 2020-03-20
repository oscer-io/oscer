<?php

namespace Bambamboole\LaravelCms\Theming;

use Bambamboole\LaravelCms\Theming\Contracts\Theme;

class DefaultTheme implements Theme
{
    public function getMenus(): array
    {
        return [
            'main' => [
                'template' => 'cms::menus.main',
            ],
            'footer' => [
                'template' => 'cms::menus.footer',
            ],
        ];
    }

    public function getFrontPageTemplate(): string
    {
        return $this->getPageTemplate();
    }

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
