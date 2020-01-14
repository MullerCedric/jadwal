<?php

namespace App\Providers;

use App\Preference;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('r-preference', function ($user, Preference $preference, $token = null) {
            if ($token) {
                return $preference->teacher->token === $token;
            } else {
                return $preference->isSent() && ($preference->examSession->user_id === $user->id);
            }
        });

        Gate::define('u-preference', function ($user, Preference $preference, $token = null) {
            if ($token) {
                return !$preference->isSent() && ($preference->teacher->token === $token);
            } else {
                return $preference->isSent() && ($preference->examSession->user_id === $user->id);
            }
        });
    }
}
