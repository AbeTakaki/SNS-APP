<?php

namespace App\Services;

use App\Models\User;
use App\Services\FollowsService;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserService {
    private $followsService;

    public function __construct(FollowsService $followsService)
    {
        $this->followsService = $followsService;
    }

    public function getUserById(int $id): UserResource
    {
        $user = User::where('id', $id)->firstOrFail();
        return new UserResource($user);
    }

    public function getUserByUserName(string $userName): UserResource
    {
        $user = User::where('user_name', $userName)->firstOrFail();
        return new UserResource($user);
    }

    public function getFollowsProfiles(int $id): AnonymousResourceCollection
    {
        $followers = $this->followsService->getFollows($id);
        $userIds = array();

        foreach ($followers as $follower) {
            array_push(
                $userIds, $follower->followed_user_id
            );
        }

        $users = User::with('image')->whereIn('id', $userIds)->get();
        return UserResource::collection($users);
    }

    public function getFollowersProfiles(int $id): AnonymousResourceCollection
    {
        $follows=$this->followsService->getFollowers($id);
        $userIds=array();
        foreach($follows as $follow){
            array_push($userIds,$follow->following_user_id);
        }

        $users=User::with('image')->whereIn('id',$userIds)->get();
        return UserResource::collection($users);
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