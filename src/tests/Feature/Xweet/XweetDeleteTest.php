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
    $response = $this->delete('/xweet/delete/1');
    $response->assertRedirect('/login');
});

test('別ユーザでは、Xweet削除できない', function(){
    $this->post('/login', [
        'email' => $this->user2->email,
        'password' => 'password',
    ]);
    $response = $this->delete('/xweet/delete/1');
    $response->assertStatus(403);
});

test('ログイン後、Xweet削除しレスポンスが返る', function(){
    $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);
    $response = $this->delete('/xweet/delete/1');
    $response->assertRedirect('/xweet');
    $response = $this->get('/xweet');
    $response->assertDontSee('Test Xweet');
});

test('ログイン後、Xweet削除しDBが更新される', function(){
    $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);
    $this->delete('/xweet/delete/1');
    $this->assertDatabaseMissing('xweets',['content'=>'Test Xweet']);
});