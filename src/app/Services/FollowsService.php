<?php

namespace App\Services;
use App\Models\Follows;
use Illuminate\Database\Eloquent\Collection;

class FollowsService {

    /**
     * ユーザーがフォローしているユーザー一覧を取得
     *
     * @param  int $userId フォローを実行したユーザーID
     * @return Collection  フォロー対象ユーザーのコレクション
     */
    public function getFollows(int $userId): Collection
    {
        $user = Follows::where('following_user_id', $userId)->get();
        return $user;
    }

    /**
     * 指定ユーザーのフォロワー一覧を取得
     *
     * @param  int  $userId  フォロワー一覧を取得したい対象ユーザーの ID (followed_user_id)
     * @return Collection  フォロワーのコレクション
     */
    public function getFollowers(int $userId): Collection
    {
        $users = Follows::where('followed_user_id', $userId)->get();
        return $users;
    }

    /**
     * ユーザー1 がユーザー2 をフォローしているか判定
     *
     * @param  int  $followerId   フォローする側のユーザーID
     * @param  int  $followedId   フォロー対象のユーザーID
     * @return bool               true の場合、フォロー中
     */
    public function isFollow(int $userId1, int $userId2) : bool 
    {
        return Follows::where([
            ['following_user_id', $userId1],
            ['followed_user_id', $userId2],
        ])->exists();
    }
}