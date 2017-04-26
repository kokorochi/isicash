<?php

namespace App\GlobalClass;

use App\User;

class UserAuth {
    public function isSuperUser(User $user)
    {
        return $user->userAuth()->where('auth_type', 'SU')->exists();
    }

    public function isAdmin(User $user)
    {
        return $user->userAuth()->where('auth_type', 'A')->exists();
    }

    public function isUser(User $user)
    {
        return $user->userAuth()->where('auth_type', 'U')->exists();
    }
}