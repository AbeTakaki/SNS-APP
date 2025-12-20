<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * Eloquent モデルのプロパティとリレーション、よく使うスコープを定義します。
 *
 * @property int $id
 * @property string $user_name
 * @property string $display_name
 * @property string $email
 * @property string $password
 * @property string|null $profile
 * @property int|null $profile_image_id
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Xweet[] $xweets
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 *
 * @mixin \Eloquent
 */

class User extends Authenticatable
{
    use HasApiTokens,HasFactory;
    protected $fillable = [
        'user_name',
        'display_name',
        'email',
        'password',
    ];
    
    
    public function xweets()
    {
        return $this->hasMany(Xweet::class);
    }

    // images リレーション
    public function image()
    {
        return $this->hasOne(Image::class,'id','profile_image_id');
    }

    // 画像パスの取得関数
    public function getImagePath()
    {
        if($this->profile_image_id) return $this->image->path;
        else return null;
    }
}
