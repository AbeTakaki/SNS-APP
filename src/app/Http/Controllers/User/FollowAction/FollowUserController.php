<?php

namespace App\Http\Controllers\User\FollowAction;

use App\Http\Controllers\Controller;
use App\Models\Follows;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $userName)
    {
        // ログインしているユーザーのIDを取得
        $following = Auth::id();
        // 指定されたユーザの存在チェックかつフォロー対象のデータを取得
        $user = User::where('user_name', $userName)->firstOrFail();
        // フォロー対象のidを取得
        $follower = $user->id;

        // 重複フォローの確認
        $follows = Follows::where([
            ['following_user_id', $following],
            ['followed_user_id', $follower],
        ])->first();

        // 重複ではない場合はフォローできる
        if(!$follows) {
            $follows = new Follows;
            $follows->following_user_id = $following;
            $follows->followed_user_id = $follower;
            $follows->save();
        }

        return redirect()->route('user.index', ['userName'=>$userName]);
    }
}
