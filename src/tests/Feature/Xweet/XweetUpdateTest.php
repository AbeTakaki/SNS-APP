<?php

use App\Models\User;
use App\Models\Xweet;

$user;
$user2;
$xweet;

//事前にユーザを2名作成し、1人目でXweetを1つ作っておく
beforeEach(function(){
    $this->user = User::factory()->create();
    $this->user2 = User::factory()->create();
    $this->xweet = Xweet::factory()->create([
        'id' => 1,
        'user_id' => $this->user->id,
        'content' => 'Test Xweet',
    ]);
});

test('非ログイン時、Xweet更新画面に移動するとログイン画面にリダイレクト', function(){
    $response = $this->get('/xweet/update/1');
    $response->assertRedirect('/login');
});

test('非ログイン時、Xweet更新しようとするとログイン画面にリダイレクト', function(){
    $response = $this->put('/xweet/update/1',[
        'xweet'=>'Edited Test Xweet',
    ]);
    
    $response->assertRedirect('/login');
});

test('別ユーザでは、Xweet更新画面に移動できない', function(){
    $this->post('/login', [
        'email' => $this->user2->email,
        'password' => 'password',
    ]);
    $response = $this->get('/xweet/update/1');
    $response->assertStatus(403);
});

test('別ユーザでは、Xweet更新できない', function(){
    $this->post('/login', [
        'email' => $this->user2->email,
        'password' => 'password',
    ]);
    $response = $this->put('/xweet/update/1',[
        'xweet'=>'Edited Test Xweet',
    ]);
    $response->assertStatus(403);
});

test('ログイン後、Xweet更新画面に移動できる', function(){
    $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);
    $response = $this->get('/xweet/update/1');
    $response->assertStatus(200);
});

test('ログイン後、Xweet更新しレスポンスが返る', function(){
    $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);
    $response = $this->put('/xweet/update/1',[
        'xweet'=>'Edited Test Xweet',
    ]);
    
    $response->assertRedirect('/xweet');
    $response = $this->get('/xweet');
    $response->assertSee('Edited Test Xweet');
});

test('ログイン後、Xweet更新しDBが更新される', function(){
    $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);
    $this->put('/xweet/update/1',[
        'xweet'=>'Edited Test Xweet',
    ]);

    $this->assertDatabaseHas('xweets',['content'=>'Edited Test Xweet']);
});

test('ログイン後、バリデーションを満たさない内容では更新できない', function(){
    $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);
    $response = $this->put('/xweet/update/1',[
        'xweet'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,',
    ])->assertInvalid(['xweet'=>'つぶやき は 140 文字以下で入力してください',]);
});