# DefaultTheme

The `DefaultTheme` which comes with LaravelCms looks like this:

```php
<?php

namespace Bambamboole\LaravelCms\Themes;

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
```

It is responsible for the paths of the views which are used for different parts of the CMS.
