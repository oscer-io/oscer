<?php

use Bambamboole\LaravelCms\Http\Controllers\MenusController;
use Bambamboole\LaravelCms\Http\Controllers\PagesController;
use Bambamboole\LaravelCms\Http\Controllers\PostsController;
use Bambamboole\LaravelCms\Http\Controllers\ProfileController;
use Bambamboole\LaravelCms\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');

Route::get('/pages', [PagesController::class, 'index'])->name('pages.index');

Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');

Route::get('/menus', [MenusController::class, 'index'])->name('menus.index');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
