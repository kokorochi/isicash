<?php

namespace App\Policies;

use App\Product;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy extends \App\GlobalClass\UserAuth {
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        if ($this->isSuperUser($user) || $this->isAdmin($user))
        {
            return true;
        }

        return false;
    }

    public function adminList(User $user)
    {
        if ($this->isSuperUser($user) || $this->isAdmin($user))
        {
            return true;
        }

        return false;
    }
}
