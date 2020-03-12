<?php

use Bambamboole\LaravelCms\Http\Controllers\MenusController;
use Bambamboole\LaravelCms\Http\Controllers\PagesController;
use Bambamboole\LaravelCms\Http\Controllers\PostsController;
use Bambamboole\LaravelCms\Http\Controllers\ProfileController;
use Bambamboole\LaravelCms\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');
Route::get('/posts/{post}', [PostsController::class, 'show'])->name('posts.show');
Route::put('/posts/{post}', [PostsController::class, 'update'])->name('posts.update');
Route::get('/posts/{post}/edit', [PostsController::class, 'edit'])->name('posts.edit');

Route::get('/pages', [PagesController::class, 'index'])->name('pages.index');

Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('/users', [UsersController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');

Route::get('/menus', [MenusController::class, 'index'])->name('menus.index');
Route::get('/menus/{name}', [MenusController::class, 'show'])->name('menus.show');
Route::post('/menus/{name}', [MenusController::class, 'store'])->name('menus.store');
Route::post('/menus/{name}/save_order', [MenusController::class, 'saveOrder'])->name('menus.save_order');
Route::put('/menus/{item}', [MenusController::class, 'update'])->name('menus.update');
Route::delete('/menus/{item}', [MenusController::class, 'delete'])->name('menus.delete');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
