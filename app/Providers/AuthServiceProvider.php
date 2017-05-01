<?php

namespace App\Providers;

use App\Order;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Product::class => ProductPolicy::class,
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isSuperUser', function($user){
            return $user->userAuth()->where('auth_type', 'SU')->exists();
        });

        Gate::define('isAdmin', function($user){
            return $user->userAuth()->where('auth_type', 'A')->exists();
        });

        Gate::define('isUser', function($user){
            return $user->userAuth()->where('auth_type', 'U')->exists();
        });
    }
}
