<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\MakeChatRoomController;
use App\Http\Controllers\Chat\PostController as ChatPostController; // エイリアスを使用
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
use App\Models\Chat;
use App\Models\Follows;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Xweet;
use Illuminate\Support\Facades\Storage;

Route::get('/test', function(Request $request) {
    return response()->json([
        "message" => "API TEST",
    ], 200);
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// --- Xweet関連 ---

// --- 公開ルート ---
// GET /xweet は認証不要のため、グループの外に残す
Route::get('/xweet', IndexController::class)->name('xweet.index'); 

// --- 認証必須ルート ---
Route::prefix('xweet')->middleware('auth:sanctum')->group(function () {
    // POST /xweet/create
    Route::post('create', XweetPostController::class);
    // GET /xweet/update/{xweetId}
    Route::get('update/{xweetId}', UpdateController::class)->name('xweet.update');
    // PUT /xweet/update/{xweetId}
    Route::put('update/{xweetId}', PutController::class)->name('xweet.update.put');
    // DELETE /xweet/delete/{xweetId}
    Route::delete('delete/{xweetId}', DeleteController::class)->name('xweet.delete');
});

// --- チャット関連 ---

Route::prefix('chat')->middleware('auth:sanctum')->group(function () {
    // GET /chat/{chatId} (チャットルーム表示)
    Route::get('{chatId}', ChatController::class)->name('chat.index');
    // POST /chat/{chatId} (メッセージ投稿)
    Route::post('{chatId}', ChatPostController::class);
});

// --- ユーザー関連 ---

// ルートのプレフィックスにパラメータを含めず、静的な /user のみを使用
Route::prefix('user')->group(function () {
    // GET /user/{userName}
    Route::get('{userName}', UserController::class)->name('user.index');

    // 認証が必要なユーザー操作
    Route::middleware('auth:sanctum')->group(function () {
        // POST /user/{userName}/follow
        Route::post('{userName}/follow', FollowUserController::class);
        // DELETE /user/{userName}/unfollow
        Route::delete('{userName}/unfollow', UnFollowUserController::class);

        // GET /user/{userName}/follows
        Route::get('{userName}/follows', FollowsController::class)->name('user.follows');
        // GET /user/{userName}/followers
        Route::get('{userName}/followers', FollowersController::class)->name('user.followers');

        // GET /user/{userName}/edit
        Route::get('{userName}/edit', EditController::class)->name('user.edit');
        // PUT /user/{userName}/edit
        Route::put('{userName}/edit', EditPutController::class)->name('user.edit.put');

        // POST /user/{userName}/chat (チャットルーム作成)
        // ルートの競合を避けるため、chat関連は下にまとめることを推奨しますが、ここでは元の位置を尊重しつつ修正
        Route::post('{userName}/chat', MakeChatRoomController::class); 
    });
});

// テスト用のルーティング
Route::post('/test/reset-db', function () {
    if(env('APP_ENV') === 'production') {
        return response()->json(['error' => 'Forbidden'], Response::HTTP_FORBIDDEN);
    }
    Artisan::call('migrate:fresh --seed');
    return response()->json(['message' => 'Database reset'], Response::HTTP_OK);
});

Route::post('/test/create-testuser', function () {
   if (env('APP_ENV') === 'production') {
      return response()->json(['error' => 'Forbidden'], Response::HTTP_FORBIDDEN);
   }
   $user = User::factory()->create([
      'profile'=>'Test User',
   ]);

   return response()->json([
      'id' => $user->id,
      'user_name' => $user->user_name,
      'display_name' => $user->display_name,
      'email' => $user->email,
      'profile' => $user->profile,
   ],Response::HTTP_CREATED);
});

Route::post('/test/create-testxweet', function (Request $request) {
   if (env('APP_ENV') === 'production') {
      return response()->json(['error' => 'Forbidden'], Response::HTTP_FORBIDDEN);
   }
   $xweet = Xweet::factory()->create([
      'user_id'=>$request->user_id,
      'content'=>$request->xweet,
   ]);
   return response()->json([
      'id' => $xweet->id,
   ],Response::HTTP_CREATED);
});

Route::post('/test/create-testfollow', function (Request $request) {
   if (env('APP_ENV') === 'production') {
      return response()->json(['error' => 'Forbidden'], Response::HTTP_FORBIDDEN);
   }
   $follow = Follows::factory()->create([
      'following_user_id'=>$request->following_id,
      'followed_user_id'=>$request->followed_id,
   ]);
   return response()->json([
      'id' => $follow->id,
   ],Response::HTTP_CREATED);
});

Route::post('/test/clear-image-disk', function (Request $request) {
   if (env('APP_ENV') === 'production') {
      return response()->json(['error' => 'Forbidden'], Response::HTTP_FORBIDDEN);
   }
   $user=User::where(['user_name'=>$request->user_name,])->first();
   if(env('APP_ENV') === 'ci'){
      $path=$user->getImagePath();
      $div=preg_split("/\//",$path);
      Storage::disk('s3')->delete(end($div));
   }else{
      Storage::disk('public')->delete($user->getImagePath());
   }
});

Route::post('/test/create-testchat', function (Request $request) {
   if (env('APP_ENV') === 'production') {
      return response()->json(['error' => 'Forbidden'], Response::HTTP_FORBIDDEN);
   }
   $chat=Chat::factory()->create([
      'user1_id'=>$request->user1_id,
      'user2_id'=>$request->user2_id,
   ]);
   return response()->json([
      'id' => $chat->id,
   ],Response::HTTP_CREATED);
});