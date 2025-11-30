<?php

namespace App\Http\Requests\Xweet;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(Auth::check()){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'xweet' => [
                'required', 
                'string', 
                'max:140',
            ],
        ];
    }

    /**
    * リクエストかた投稿内容を取得
    * @return string 投稿テキスト
    */
    public function getXweet(): string
    {
        return $this->input('xweet');
    }
    /**
    * ログインユーザーのIDを取得するメソッド
    * @return int ユーザーID
    */
    public function getUserId() : int
    {
        return $this->user()->id;
    }
}
