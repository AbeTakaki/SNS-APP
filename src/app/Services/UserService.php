<?php

namespace App\Services;

use App\Models\User;

class UserService {

    public function getUserById(int $id): User
    {
        $user = User::where('id', $id)->firstOrFail();
        return $user;
    }
}