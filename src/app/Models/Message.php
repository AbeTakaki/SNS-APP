<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Message モデル
 *
 * @property int $id
 * @property int $chat_id
 * @property int $mentioned_user_id
 * @property string $content
 *
 * @mixin \Eloquent
 */
class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'mentioned_user_id',
        'content',
    ];

    public function quser()
    {
        return $this->belongsTo(User::class,'mentioned_user_id');
    }

    public function getDisplayName()
    {
        return $this->quser->display_name;
    }
}
