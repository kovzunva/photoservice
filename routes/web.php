<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentMakerController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

// Контент-мейкер
// маршрути, які доступні тільки для адміністраторів
Route::group(['middleware' => 'role:admin'], function () {
    Route::get('/content-maker', [ContentMakerController::class, 'basic']);
});

// 
// Клієнтська частина
Route::get('/', [MainPageController::class, 'show']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Блог
Route::get('/items', [ItemController::class, 'showAll'])->name('items');
Route::get('/items/page/{page}', [ItemController::class, 'showAll'])->name('itemPage');
Route::get('/item/{id}', [ItemController::class, 'show'])->name('item');

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
    Route::get('/profile/item', [ItemController::class, 'emptyForm']);
    Route::get('/profile/item/{id}', [ItemController::class, 'edit']);
    Route::post('/profile/item/{id}/edit', [ItemController::class, 'edit']);
    Route::get('/profile/item/{id}/del', [ItemController::class, 'destroy']);
    Route::get('/profile/items', [ItemController::class, 'usersitems'])->name('my-items');
    Route::post('/profile/item/add', [ItemController::class, 'add']);
});
Route::get('/profiles', [ProfileController::class, 'showAll']);