<?php

namespace App\Services;
use App\Models\Xweet;

class XweetService {

    public function createXweet(int $userId, string $content): void
    {
        $xweet = new Xweet;
        $xweet->user_id = $userId;
        $xweet->content = $content;
        $xweet->save();
    }

    public function getXweetById(int $id): Xweet
    {
      $xweet = Xweet::where('id', $id)->FirstOrFail();
      return $xweet;
    }

    public function updateXweet(int $id, string $content): void
    {
        $xweet = Xweet::where('id',$id)->first();
        $xweet->content = $content;
        $xweet->save();
    }

    public function deleteXweet(int $id): void
    {
      $xweet = Xweet::where('id', $id)->first();
      $xweet->delete();
    }
}