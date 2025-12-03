<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\User;

/**
 * ChatPolicy
 *
 * チャットルームリソースに対する認可ルールを定義するポリシークラス。
 *
 * - enter: チャットルームへのアクセス可否を判定（参加者本人のみ許可）
 *
 * @package App\Policies
 */

class ChatPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can enter the given chat room.
     *
     * チャットルームへのアクセスを制御します。
     * チャット作成者（user_id）またはもう一方の参加者（user2_id）のみアクセス可能です。
     *
     * @param  \App\Models\User  $user 実行を試みる認証済みユーザー
     * @param  \App\Models\Chat  $chat 対象のチャットルーム
     * @return bool                    true の場合、アクセスを許可
     */
    
    public function enter(User $user, Chat $chat): bool
    {
        if($chat->user_id === $user->id || $chat->user2_id === $user->id){
            return true;
        } else {
            return false;
        }
    }
}
