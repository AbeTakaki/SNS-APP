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

// Xweet関連
Route::get('/xweet', \App\Http\Controllers\Xweet\IndexController::class)->name('xweet.index');
Route::get('/xweet/create', \App\Http\Controllers\Xweet\Create\CreateController::class)->middleware('auth');
Route::post('/xweet/create', \App\Http\Controllers\Xweet\Create\PostController::class)->middleware('auth');
Route::get('/xweet/update/{xweetId}', \App\Http\Controllers\Xweet\Update\UpdateController::class)->middleware('auth')->name('xweet.update');
Route::put('/xweet/update/{xweetId}', \App\Http\Controllers\Xweet\Update\PutController::class)->middleware('auth')->name('xweet.update.put');
Route::delete('/xweet/delete/{xweetId}', \App\Http\Controllers\Xweet\Delete\DeleteController::class)->middleware('auth')->name('xweet.delete');

// ユーザー関連
Route::get('/user/{userName}', \App\Http\Controllers\User\UserController::class)->name('user.index');
Route::get('/user/{userName}/follows', \App\Http\Controllers\User\FollowsController::class);
Route::get('/user/{userName}/followers', \App\Http\Controllers\User\FollowersController::class);
Route::post('/user/{userName}/follow', \App\Http\Controllers\User\FollowAction\FollowUserController::class)->middleware('auth');
Route::delete('/user/{userName}/unfollow',\App\Http\Controllers\User\FollowAction\UnFollowUserController::class)->middleware('auth');

// チャット関連
Route::get('/chat/{chatId}', \App\Http\Controllers\Chat\ChatController::class)->middleware('auth')->name('chat.index');
Route::post('/chat/{chatId}', \App\Http\Controllers\Chat\PostController::class)->middleware('auth');
Route::post('/user/{userName}/chat', \App\Http\Controllers\Chat\MakeChatRoomController::class)->middleware('auth');

require __DIR__.'/auth.php';
