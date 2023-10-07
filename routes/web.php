<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentMakerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

// 
// Клієнтська частина
Route::get('/', [PostController::class, 'showAll']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Пост
Route::get('/posts', [PostController::class, 'showAll'])->name('posts');
Route::get('/posts/page/{page}', [PostController::class, 'showAll'])->name('postPage');
Route::get('/post/{id}', [PostController::class, 'show'])->name('post');

// Вподобайка
Route::post('/like', [LikeController::class, 'like']);

// Коментарі
Route::post('/comment/add', [CommentController::class, 'add']);
Route::post('/comment/{id}/edit', [CommentController::class, 'edit']);
Route::get('/comment/{id}/del', [CommentController::class, 'del']);

// Реєстрація, автентифікація
Auth::routes();

// Профіль користувача
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [ProfileController::class, 'myProfile'])->name('my-profile');
    Route::get('/profile/post', [PostController::class, 'emptyForm']);
    Route::get('/profile/post/{id}', [PostController::class, 'edit']);
    Route::post('/profile/post/{id}/edit', [PostController::class, 'edit']);
    Route::get('/profile/post/{id}/del', [PostController::class, 'destroy']);
    Route::get('/profile/posts', [PostController::class, 'usersPosts'])->name('my-posts');
    Route::post('/profile/post/add', [PostController::class, 'add']);
});