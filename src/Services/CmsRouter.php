<?php

namespace Bambamboole\LaravelCms\Services;

use Bambamboole\LaravelCms\Http\Controllers\Auth\ForgotPasswordController;
use Bambamboole\LaravelCms\Http\Controllers\Auth\LoginController;
use Bambamboole\LaravelCms\Http\Controllers\Backend\MenusController;
use Bambamboole\LaravelCms\Http\Controllers\Backend\OptionsController;
use Bambamboole\LaravelCms\Http\Controllers\Backend\PagesController;
use Bambamboole\LaravelCms\Http\Controllers\Backend\PostsController;
use Bambamboole\LaravelCms\Http\Controllers\Backend\ProfileController;
use Bambamboole\LaravelCms\Http\Controllers\Backend\UsersController;
use Bambamboole\LaravelCms\Http\Controllers\PagesController as FrontendPagesController;
use Bambamboole\LaravelCms\Http\Controllers\PostsController as FrontendPostsController;
use Bambamboole\LaravelCms\Http\Middleware\Authenticate;
use Bambamboole\LaravelCms\Http\Middleware\SetInertiaConfiguration;
use Bambamboole\LaravelCms\Http\Middleware\SetLocale;
use Bambamboole\LaravelCms\Models\Option;
use Bambamboole\LaravelCms\Models\Page;
use Illuminate\Config\Repository;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class CmsRouter
{
    protected Router $router;

    protected Repository $config;

    public function __construct(Router $router, Repository $config)
    {
        $this->router = $router;
        $this->config = $config;
    }

    public function registerPagesRoutes(string $pathPrefix = '')
    {
        /** @var Collection $pages */
        $pages = Cache::rememberForever('cms.slugs', function () {
            if (! Schema::connection(config('cms.database_connection'))->hasTable('pages')) {
                return new Collection();
            }

            return Page::query()->get('slug');
        });

        $this->router
            ->middleware([$this->config->get('cms.pages.middleware'), SetLocale::class])
            ->prefix($pathPrefix)
            ->as('cms.')
            ->group(function (Router $router) use ($pages) {
                $frontPageSlug = Option::getValueByKey('pages/front_page');
                $pages->filter(function (Page $page) use ($router, $frontPageSlug) {
                    if ($page->slug === $frontPageSlug) {
                        $router->get('/', [FrontendPagesController::class, 'frontPage'])
                            ->name('pages.front_page');

                        return false;
                    }

                    return true;
                })->each(function (Page $page) use ($router) {
                    $router->get("/{$page->slug}", [FrontendPagesController::class, 'show'])
                        ->name("pages.{$page->slug}");
                });
            });
    }

    public function registerPostsRoutes(string $pathPrefix = 'posts')
    {
        $this->router
            ->middleware([$this->config->get('cms.posts.middleware'), SetLocale::class])
            ->prefix($pathPrefix)
            ->as('cms.')
            ->group(function (Router $router) {
                $router->get('/', [FrontendPostsController::class, 'index'])->name('posts.index');
                $router->get('/{slug}', [FrontendPostsController::class, 'show'])->name('posts.show');
            });
    }

    public function registerAuthRoutes()
    {
        $this->router->middleware([$this->config->get('cms.backend.middleware'), SetLocale::class])
            ->as('cms.')
            ->prefix($this->config->get('cms.backend.url'))
            ->group(function (Router $router) {
                $router->get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
                $router->post('/login', [LoginController::class, 'login'])->name('auth.attempt');
                $router->get('/logout', [LoginController::class, 'logout'])->name('auth.logout');

                $router->get('/password/forgot', [ForgotPasswordController::class, 'showResetRequestForm'])->name('password.forgot');
                $router->post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
                $router->get('/password/reset/{token}', [ForgotPasswordController::class, 'showNewPassword'])->name('password.reset');
            });
    }

    public function registerBackendRoutes(): void
    {
        $this->router
            ->middleware([
                $this->config->get('cms.backend.middleware'),
                Authenticate::class,
                SetInertiaConfiguration::class,
                SetLocale::class,
            ])
            ->as('cms.backend.')
            ->prefix($this->config->get('cms.backend.url'))
            ->group(function (Router $router) {
                $router->post('/posts', [PostsController::class, 'store'])->name('posts.store');
                $router->get('/posts', [PostsController::class, 'index'])->name('posts.index');
                $router->get('/posts/create', [PostsController::class, 'create'])->name('posts.create');
                $router->get('/posts/{post}', [PostsController::class, 'show'])->name('posts.show');
                $router->put('/posts/{post}', [PostsController::class, 'update'])->name('posts.update');
                $router->get('/posts/{post}/edit', [PostsController::class, 'edit'])->name('posts.edit');

                $router->get('/pages', [PagesController::class, 'index'])->name('pages.index');
                $router->get('/pages/create', [PagesController::class, 'create'])->name('pages.create');
                $router->post('/pages', [PagesController::class, 'store'])->name('pages.store');
                $router->get('/pages/{page}', [PagesController::class, 'show'])->name('pages.show');
                $router->get('/pages/{page}/edit', [PagesController::class, 'edit'])->name('pages.edit');
                $router->put('/pages/{page}', [PagesController::class, 'update'])->name('pages.update');
                $router->delete('/pages/{page}', [PagesController::class, 'delete'])->name('pages.delete');

                $router->get('/users', [UsersController::class, 'index'])->name('users.index');
                $router->get('/users/create', [UsersController::class, 'create'])->name('users.create');
                $router->post('/users', [UsersController::class, 'store'])->name('users.store');
                $router->get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
                $router->get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
                $router->put('/users/{user}', [UsersController::class, 'update'])->name('users.update');

                $router->get('/menus', [MenusController::class, 'index'])->name('menus.index');
                $router->get('/menus/{name}', [MenusController::class, 'show'])->name('menus.show');
                $router->post('/menus/{name}', [MenusController::class, 'store'])->name('menus.store');
                $router->post('/menus/{name}/save_order', [MenusController::class, 'saveOrder'])->name('menus.save_order');
                $router->put('/menus/{item}', [MenusController::class, 'update'])->name('menus.update');
                $router->delete('/menus/{item}', [MenusController::class, 'delete'])->name('menus.delete');

                $router->get('/profile', [ProfileController::class, 'show'])->name('profile.show');
                $router->get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
                $router->put('/profile', [ProfileController::class, 'update'])->name('profile.update');

                $router->get('/options', [OptionsController::class, 'index'])->name('options.index');
            });
    }
}
