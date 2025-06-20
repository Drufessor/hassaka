<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('view-audit-logs', function ($user) {
            return $user->role->name === 'admin';
        });

        Gate::define('fetch-data', function ($user) {
            return in_array($user->role->name, ['admin', 'marketing']);
        });
    }
} 