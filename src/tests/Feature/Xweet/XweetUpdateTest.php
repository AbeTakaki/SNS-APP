<?php

use App\Models\User;
use App\Models\Xweet;

$user;
$user2;
$xweet;

//事前にユーザを2名作成し、1人目でXweetを1つ作っておく
beforeEach(function(){
    $this->user=User::factory()->create();
    $this->user2=User::factory()->create();
    $this->xweet=Xweet::factory()->create([
        'id'=>1,
        'user_id'=>$this->user->id,
        'content'=>'Test Xweet',
    ]);
});

test('非ログイン時、Xweet更新しようとするとログイン画面にリダイレクト', function(){
    $response = $this->put('/api/xweet/update/1',[
        'xweet'=>'Edited Test Xweet',
    ]);
    $response->assertStatus(401);
});

test('別ユーザでは、Xweet更新できない', function(){
    $token = $this->user2->createToken('AccessToken')->plainTextToken;
    $response = $this->put('/api/xweet/update/1',[
        'xweet'=>'Edited Test Xweet',
    ],[
        'Authorization' => 'Bearer '.$token,
    ]);
    $response->assertStatus(403);
});

test('ログイン後、Xweet更新しレスポンスが返る', function(){
    $token = $this->user->createToken('AccessToken')->plainTextToken;
    $response = $this->put('/api/xweet/update/1',[
        'xweet'=>'Edited Test Xweet',
    ],[
        'Authorization' => 'Bearer '.$token,
    ]);
    $response->assertStatus(204);
});

test('ログイン後、Xweet更新しDBが更新される', function(){
    $token = $this->user->createToken('AccessToken')->plainTextToken;
    $this->put('/api/xweet/update/1',[
        'xweet'=>'Edited Test Xweet',
    ],[
        'Authorization' => 'Bearer '.$token,
    ]);
    $this->assertDatabaseHas('xweets',['content'=>'Edited Test Xweet']);
});

test('ログイン後、バリデーションを満たさない内容では更新できない', function(){
    $token = $this->user->createToken('AccessToken')->plainTextToken;
    $response = $this->put('/api/xweet/update/1',[
        'xweet'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,',
    ],[
        'Authorization' => 'Bearer '.$token,
    ])->assertStatus(422)->assertJson(['message'=>'つぶやき は 140 文字以下で入力してください',]);
});