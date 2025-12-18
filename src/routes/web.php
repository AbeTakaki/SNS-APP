<?php

use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\MakeChatRoomController;
use App\Http\Controllers\Chat\PostController as ChatPostController; // エイリアスを使用
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\Edit\EditController;
use App\Http\Controllers\User\Edit\EditPutController;
use App\Http\Controllers\User\FollowAction\FollowUserController;
use App\Http\Controllers\User\FollowAction\UnFollowUserController;
use App\Http\Controllers\User\FollowersController;
use App\Http\Controllers\User\FollowsController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Xweet\Create\CreateController;
use App\Http\Controllers\Xweet\Create\PostController as XweetPostController; // エイリアスを使用
use App\Http\Controllers\Xweet\Delete\DeleteController;
use App\Http\Controllers\Xweet\IndexController;
use App\Http\Controllers\Xweet\Update\PutController;
use App\Http\Controllers\Xweet\Update\UpdateController;
use Illuminate\Support\Facades\Route;

// --- 基本ルート ---

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// // --- Xweet関連 ---

// // --- 公開ルート ---
// // GET /xweet は認証不要のため、グループの外に残す
// Route::get('/xweet', IndexController::class)->name('xweet.index'); 

// // --- 認証必須ルート ---
// Route::prefix('xweet')->middleware('auth')->group(function () {
//     // GET /xweet/create
//     Route::get('create', CreateController::class)->name('xweet.create');
//     // POST /xweet/create
//     Route::post('create', XweetPostController::class);
//     // GET /xweet/update/{xweetId}
//     Route::get('update/{xweetId}', UpdateController::class)->name('xweet.update');
//     // PUT /xweet/update/{xweetId}
//     Route::put('update/{xweetId}', PutController::class)->name('xweet.update.put');
//     // DELETE /xweet/delete/{xweetId}
//     Route::delete('delete/{xweetId}', DeleteController::class)->name('xweet.delete');
// });

// // --- チャット関連 ---

// Route::prefix('chat')->middleware('auth')->group(function () {
//     // GET /chat/{chatId} (チャットルーム表示)
//     Route::get('{chatId}', ChatController::class)->name('chat.index');
//     // POST /chat/{chatId} (メッセージ投稿)
//     Route::post('{chatId}', ChatPostController::class);
// });

// // --- ユーザー関連 ---

// // ルートのプレフィックスにパラメータを含めず、静的な /user のみを使用
// Route::prefix('user')->group(function () {
//     // GET /user/{userName}
//     Route::get('{userName}', UserController::class)->name('user.index');

//     // 認証が必要なユーザー操作
//     Route::middleware('auth')->group(function () {
//         // POST /user/{userName}/follow
//         Route::post('{userName}/follow', FollowUserController::class);
//         // DELETE /user/{userName}/unfollow
//         Route::delete('{userName}/unfollow', UnFollowUserController::class);

//         // GET /user/{userName}/follows
//         Route::get('{userName}/follows', FollowsController::class)->name('user.follows');
//         // GET /user/{userName}/followers
//         Route::get('{userName}/followers', FollowersController::class)->name('user.followers');

//         // GET /user/{userName}/edit
//         Route::get('{userName}/edit', EditController::class)->name('user.edit');
//         // PUT /user/{userName}/edit
//         Route::put('{userName}/edit', EditPutController::class)->name('user.edit.put');

//         // POST /user/{userName}/chat (チャットルーム作成)
//         // ルートの競合を避けるため、chat関連は下にまとめることを推奨しますが、ここでは元の位置を尊重しつつ修正
//         Route::post('{userName}/chat', MakeChatRoomController::class); 
//     });
// });

require __DIR__.'/auth.php';
