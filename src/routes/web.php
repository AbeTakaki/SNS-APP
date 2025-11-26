<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/xweet', \App\Http\Controllers\Xweet\IndexController::class);
Route::get('/xweet/create', \App\Http\Controllers\Xweet\Create\CreateController::class);
Route::get('/user/{userName}', \App\Http\Controllers\User\UserController::class);
Route::get('/user/{userName}/follows', \App\Http\Controllers\User\FollowsController::class);
Route::get('/user/{userName}/followers', \App\Http\Controllers\User\FollowersController::class);

require __DIR__.'/auth.php';
