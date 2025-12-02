<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Xweet;

/**
 * XweetPolicy
 *
 * Xweet（投稿）に対する認可ロジックを定義するポリシークラス。
 *
 * - update: 投稿の更新可否を判定（投稿者本人のみ許可）
 * - delete: 投稿の削除可否を判定（投稿者本人のみ許可）
 *
 * @package App\Policies
 */

class XweetPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can update the given xweet.
     *
     * @param  \App\Models\User  $user  実行を試みるユーザー
     * @param  \App\Models\Xweet $xweet 対象の投稿
     * @return bool               true の場合、更新を許可
     */
    public function update(User $user, Xweet $xweet): bool
    {
        return $xweet->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the given xweet.
     *
     * @param  \App\Models\User  $user  実行を試みるユーザー
     * @param  \App\Models\Xweet $xweet 対象の投稿
     * @return bool               true の場合、削除を許可
     */
    public function delete(User $user, Xweet $xweet): bool
    {
        return $xweet->user_id === $user->id;
    }
}
