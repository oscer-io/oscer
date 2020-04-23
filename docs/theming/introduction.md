# Introduction

Laravel CMS has a simple but powerful Theming System. 
it is based on Laravel's [Blade](https://laravel.com/docs/7.x/blade) engine and configured by a PHP class 
which has to implement a specific interface. All template files of the Theme have an 
instance of the Theme available via the `$theme` variable.

We have backed you with a simple `DefaultTheme` that you can extend for customization.
If you want to implement a `Theme` by you own, feel free to implement described interface.

## Theme interface

A Theme is a  PHP class which implements `Oscer\Cms\Frontend\Contracts\Theme`. All template strings which are returned
by the Theme class are read by Laravel's `view()` method.
The contract tells us to implement the following methods:


### `getMenus(): array;`

This method declares which menus are available through this theme. It is possible to declare multiple menus.
An implementation might look like this:
```php
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
```  
You can populate menu items  via the admin interface. 
Find out more about how to use menus in the [menu section](menus.md) if this documentation.

### `getFrontPageTemplate(): string;`

This method has to return a `string` which represents a Blade template. It will be used for 
rendering the front page which is set in the options. 

### `getPageTemplate(): string;`

This method has to return a `string` which represents a Blade template. It will be used for 
rendering any page call except the front page. This template gets the Page as a `$page` variable.

### `getPageTemplate(): string;`

This method has to return a `string` which represents a Blade template. It will be used for 
rendering any page call except the front page. This template gets the Page as a `$page` variable.

### `getPostsIndexTemplate(): string;`

This method has to return a `string` which represents a Blade template. It will be used for 
rendering the posts index page. This template gets a paginated collection 
of all published posts as a `$posts` variable.


### `getPostsShowTemplate(): string;`

This method has to return a `string` which represents a Blade template. It will be used for 
rendering a single post page. This template gets the current post as a `$post` variable.


### `getOptions(): array;`

This method has to return an `array` which declares additional options that are available in the  admin interface.
