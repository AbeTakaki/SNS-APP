<?php

namespace App\Policies;

use App\Models\User;

/**
 * UserPolicy
 *
 * ユーザーリソースに対する認可ルールを定義するポリシークラス。
 *
 * - update: ユーザー情報の更新を行えるか判定（基本は本人のみ許可）
 *
 * @package App\Policies
 */

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the authenticated user can update the given user.
     *
     * @param  \App\Models\User  $user  実行を試みる認証済みユーザー
     * @param  \App\Models\User  $user2 更新対象のユーザー
     * @return bool               true の場合、更新を許可
     */
    
    public function update(User $user, User $user2): bool
    {
        return $user->id === $user2->id;
    }
}
