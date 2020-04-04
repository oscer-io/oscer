<?php

namespace Bambamboole\LaravelCms\Frontend\Routing;

use Bambamboole\LaravelCms\Core\Http\Middleware\SetLocale;
use Bambamboole\LaravelCms\Frontend\Http\Controllers\PagesController;
use Bambamboole\LaravelCms\Frontend\Http\Controllers\PostsController;
use Bambamboole\LaravelCms\Options\Models\Option;
use Bambamboole\LaravelCms\Publishing\Models\Page;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;

class FrontendRouter
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    protected function isMigrated()
    {
        return Schema::hasTable('cms_posts')
            && Schema::hasTable('cms_options');
    }

    public function registerPagesRoutes(string $pathPrefix = '', $middleware = 'web')
    {
        if (! $this->isMigrated()) {
            return;
        }

        $pages = Page::query()->get('slug');

        $this->router
            ->middleware([$middleware, SetLocale::class])
            ->prefix($pathPrefix)
            ->as('cms.')
            ->group(function (Router $router) use ($pages) {
                if ($frontPageSlug = Option::getValueByKey('pages.front_page')) {
                    $pages = $pages->filter(function (Page $page) use ($router, $frontPageSlug) {
                        if ($page->slug === $frontPageSlug) {
                            $router->get('/', [PagesController::class, 'frontPage'])
                                ->name('pages.front_page');

                            return false;
                        }

                        return true;
                    });
                }
                $pages->each(function (Page $page) use ($router) {
                    $router->get("/{$page->slug}", [PagesController::class, 'show'])
                        ->name("pages.{$page->slug}");
                });
            });
    }

    public function registerPostsRoutes(string $pathPrefix = 'posts', $middleware = 'web')
    {
        $this->router
            ->middleware([$middleware, SetLocale::class])
            ->prefix($pathPrefix)
            ->as('cms.')
            ->group(function (Router $router) {
                $router->get('/', [PostsController::class, 'index'])->name('posts.index');
                $router->get('/{slug}', [PostsController::class, 'show'])->name('posts.show');
            });
    }
}
