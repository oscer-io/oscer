<?php

namespace Bambamboole\LaravelCms\Services;

use Bambamboole\LaravelCms\Http\Controllers\BlogController;
use Bambamboole\LaravelCms\Http\Middleware\SetLocale;
use Bambamboole\LaravelCms\Models\Page;
use Illuminate\Config\Repository;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Cache;

class CmsRouter
{
    protected Router $router;

    protected Repository $config;

    public function __construct(Router $router, Repository $config)
    {
        $this->router = $router;
        $this->config = $config;
    }

    public function registerBlogRoutes(string $pathPrefix = 'blog')
    {
        $this->router
            ->middleware([$this->config->get('cms.blog.middleware'), SetLocale::class])
            ->prefix($pathPrefix)
            ->as('cms.')
            ->group(function (Router $router) {
                $router->get('/', [BlogController::class, 'index'])->name('blog.index');
                $router->get('/{$slug}', [BlogController::class, 'index'])->name('blog.index');
            });
    }

    public function registerPageRoutes(string $pathPrefix = '')
    {
        $slugs = Cache::rememberForever('cms.slugs', function () {
            return Page::query()->get('slug');
        });

        $this->router
            ->middleware([$this->config->get('cms.pages.middleware'), SetLocale::class])
            ->prefix($pathPrefix)
            ->as('cms.')
            ->group(function (Router $router) use ($slugs) {
                $slugs->each(function (string $slug) use ($router) {
                    $router->get("/{$slug}", [PageRenderer::class, 'render']);
                });
            });
    }
}
