<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Xweet
 *
 * Eloquent モデルのプロパティとリレーションを IDE/静的解析向けに定義します。
 *
 * @property int $id
 * @property int $user_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Xweet whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Xweet whereContent($value)
 *
 * @mixin \Eloquent
 */

class Xweet extends Model
{
    /** @use HasFactory<\Database\Factories\XweetFactory> */
    use HasFactory; 
    
    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDisplayName() 
    {
        return $this->user->display_name;
    }
}

