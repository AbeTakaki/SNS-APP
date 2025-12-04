<?php

namespace App\Services;
use App\Models\Xweet;
use Illuminate\Database\Eloquent\Collection;

class XweetService {
    private $followService;

    public function __construct(FollowsService $followService)
    {
        $this->followService = $followService;
    }

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

    public function getAllXweets(): Collection
    {
        $xweets = Xweet::orderBy('created_at', 'DESC')->get();
          return $xweets;
    }

    public function getFollowsXweets(int $userId): Collection
    {
        $users = $this->followService->getFollows($userId);
        $followUserIds = array(
          0 => (int)$userId,
        );

        foreach($users as $user){
            $followUserIds[] = $user->followed_user_id;
        }

        $xweets = Xweet::whereIn('user_id', $followUserIds)->orderBy('created_at', 'DESC')->get();

        return $xweets;
    }

    public function getUserXweets(int $userId): Collection
    {
        $xweets = Xweet::where('user_id', $userId)->orderBy('created_at', 'DESC')->get();
        return $xweets;
    }
}