<?php

use App\Models\User;

$user;
beforeEach(function() {
    $this->user = User::factory()->create();
});

test('非ログイン時、Xweet投稿画面に移動するとログイン画面にリダイレクト', function(){
    $response = $this->get('/xweet/create');
    $response->assertRedirect('/login');
});

test('非ログイン時、Xweet投稿しようとするとログイン画面にリダイレクト', function(){
    $response = $this->post('/xweet/create',[
        'xweet'=>'Test Xweet',
    ]);
    
    $response->assertRedirect('/login');
});

test('ログイン後、Xweet投稿画面に移動できる', function(){
    $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);
    $response = $this->get('/xweet/create');
    $response->assertStatus(200);
});

test('ログイン後、xweet投稿しレスポンスが返る', function(){
    $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);
    $response = $this->post('/xweet/create',[
        'xweet'=>'Test xweet',
    ]);
    
    $response->assertRedirect('/xweet');
    $response = $this->get('/xweet');
    $response->assertSee('Test xweet');
});

test('ログイン後、xweet投稿しDBが更新される', function(){
    $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);
    $this->post('/xweet/create',[
        'xweet'=>'Test xweet',
    ]);

    $this->assertDatabaseHas('xweets',['content'=>'Test xweet']);
});

test('ログイン後、バリデーションを満たさない内容は投稿できない', function(){
    $this->post('/login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]);
    $response = $this->post('/xweet/create',[
        'xweet'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,',
    ])->assertInvalid(['xweet'=>'つぶやき は 140 文字以下で入力してください',]);
});