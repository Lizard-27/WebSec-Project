<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];



    public function boot()
    {
        $this->registerPolicies();

        Passport::tokensCan([
            'openid' => 'Retrieve ID token',
            'profile' => 'Access basic profile info',
            'email' => 'Access your email address',
        ]);
    }

}
