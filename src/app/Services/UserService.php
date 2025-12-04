<?php

namespace App\Services;

use App\Models\User;
use App\Services\FollowsService;
use Illuminate\Database\Eloquent\Collection;

class UserService {
    private $followsService;

    public function __construct(FollowsService $followsService)
    {
        $this->followsService = $followsService;
    }

    public function getUserById(int $id): User
    {
        $user = User::where('id', $id)->firstOrFail();
        return $user;
    }

    public function getUserByUserName(string $userName): User
    {
        $user = User::where('user_name', $userName)->firstOrFail();
        return $user;
    }

    public function getFollowsProfiles(int $id): Collection
    {
        $followers = $this->followsService->getFollows($id);
        $userIds = array();

        foreach ($followers as $follower) {
            array_push(
                $userIds, $follower->followed_user_id
            );
        }

        $users = User::with('image')->whereIn('id', $userIds)->get();
        return $users;
    }

    public function getFollowersProfiles(int $id):Collection{
        $follows=$this->followsService->getFollowers($id);
        $userIds=array();
        foreach($follows as $follow){
            array_push($userIds,$follow->following_user_id);
        }

        $users=User::with('image')->whereIn('id',$userIds)->get();
        return $users;
    }

    public function setDisplayName(int $id, string $displayName): void
    {
        $user = User::where('id',$id)->firstOrFail();
        $user->display_name = $displayName;
        $user->save();
    }

    public function setProfile(int $id, string|null $profile): void
    {
        $user = User::where('id',$id)->firstOrFail();
        $user->profile = $profile;
        $user->save();
    }

    public function setProfileImageId(int $id, int $profileImageId): void
    {
        $user = User::where('id',$id)->firstOrFail();
        $user->profile_image_id = $profileImageId;
        $user->save();
    }
}