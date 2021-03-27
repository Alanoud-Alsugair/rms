<?php

namespace App\Providers;

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

        Gate::define('create-report',function($user){
            return $user->hasRole('admin');
        });

        Gate::define('edit-report',function($user){
            return $user->hasRole('admin');
        });

        Gate::define('delete-report',function($user){
            return $user->hasRole('admin');
        });

        Gate::define('manage-report-files',function($user){
            return $user->hasRole('admin');
        });

        // Gate::define('show-user',function($user){
        //     return $user->hasRole('admin');
        // });
        // Gate::define('edit-user',function($user){
        //     return $user->hasRole('admin');
        // });
        // Gate::define('destroy-user',function($user){
        //     return $user->hasRole('admin');
        // });

        Gate::define('manage-users',function($user){
            return $user->hasRole('admin');
        });

        Gate::define('manage-groups',function($user){
            return $user->hasRole('admin');
        });
        Gate::define('manage',function($user){
            return $user->hasRole('admin');
        });
    }
}
