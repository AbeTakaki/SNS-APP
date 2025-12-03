<?php

namespace App\Services;
use App\Models\Follows;
use Illuminate\Database\Eloquent\Collection;

class FollowsService {

    public function getFollows(int $userId): Collection
    {
        $user = Follows::where('following_user_id', $userId)->get();
        return $user;
    }
}