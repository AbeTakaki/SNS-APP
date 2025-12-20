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

test('非ログイン時、Xweet削除しようとするとログイン画面にリダイレクト', function(){
    $response = $this->delete('/api/xweet/delete/1');
    $response->assertStatus(401);
});

test('別ユーザでは、Xweet削除できない', function(){
    $token = $this->user2->createToken('AccessToken')->plainTextToken;
    $response = $this->delete('/api/xweet/delete/1',[],[
        'Authorization' => 'Bearer '.$token,
    ]);
    $response->assertStatus(403);
});

test('ログイン後、Xweet削除しレスポンスが返る', function(){
    $token = $this->user->createToken('AccessToken')->plainTextToken;
    $response = $this->delete('/api/xweet/delete/1',[],[
        'Authorization' => 'Bearer '.$token,
    ]);
    $response->assertStatus(204);
});

test('ログイン後、Xweet削除しDBが更新される', function(){
    $token = $this->user->createToken('AccessToken')->plainTextToken;
    $this->delete('/api/xweet/delete/1',[],[
        'Authorization' => 'Bearer '.$token,
    ]);
    $this->assertDatabaseMissing('xweets',['content'=>'Test Xweet']);
});