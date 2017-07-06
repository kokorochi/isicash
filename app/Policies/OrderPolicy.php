<?php

namespace App\Policies;

use App\GlobalClass\UserAuth;
use App\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy extends UserAuth {
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

    public function view(User $user, Order $order)
    {
        if ($this->isSuperUser($user) || $this->isAdmin($user))
        {
            return true;
        }

        if ($order->username !== $user->username)
            return false;

        return true;
    }

    public function topupList(User $user)
    {
        if ($this->isSuperUser($user) || $this->isAdmin($user))
        {
            return true;
        } else
        {
            return false;
        }
    }

    public function confirmTopup(User $user)
    {
        if ($this->isSuperUser($user) || $this->isAdmin($user))
        {
            return true;
        } else
        {
            return false;
        }
    }
}
