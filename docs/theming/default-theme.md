# DefaultTheme
The `DefaultTheme` which comes with LaravelCms looks like this:

```php
<?php

namespace Bambamboole\LaravelCms\Theming;

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
