<?php

namespace App\Repositories;

use App\User;

/**
 * Get all users within Idee.
 *
 * @param  User  $user
 * @return Collection
 */
class UserRepository
{

    public function allUsers()
    {
        return User::latest()->get();
    }

}