<?php

use App\Models\User;

$user;
beforeEach(function(){
    $this->user = User::factory()->create();
});

test('非ログイン時、Xweet投稿しようとするとログイン画面にリダイレクト', function(){
    $response = $this->post('/api/xweet/create',[
        'xweet'=>'Test Xweet',
    ]);
    $response->assertStatus(401);
});

test('ログイン後、Xweet投稿しレスポンスが返る', function(){
    $token = $this->user->createToken('AccessToken')->plainTextToken;
    $response = $this->post('/api/xweet/create',[
        'xweet'=>'Test Xweet',
    ],[
        'Authorization' => 'Bearer '.$token,
    ]);
    $response->assertStatus(201);
});

test('ログイン後、Xweet投稿しDBが更新される', function(){
    $token = $this->user->createToken('AccessToken')->plainTextToken;
    $this->post('/api/xweet/create',[
        'xweet'=>'Test Xweet',
    ],[
        'Authorization' => 'Bearer '.$token,
    ]);
    $this->assertDatabaseHas('xweets',['content'=>'Test Xweet']);
});

test('ログイン後、バリデーションを満たさない内容は投稿できない', function(){
    $token = $this->user->createToken('AccessToken')->plainTextToken;
    $response = $this->post('/api/xweet/create',[
        'xweet'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,',
    ],[
        'Authorization' => 'Bearer '.$token,
    ])->assertStatus(422)->assertJson(['message'=>'つぶやき は 140 文字以下で入力してください',]);
});