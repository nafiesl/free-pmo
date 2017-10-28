<?php

namespace App\Providers;

use App\Entities\Users\Permission;
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
        'App\Entities\Partners\Partner' => 'App\Policies\Partners\PartnerPolicy',
        'App\Entities\Projects\Project' => 'App\Policies\Projects\ProjectPolicy',
        'App\Entities\Users\Event'      => 'App\Policies\EventPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Dynamically register permissions with Laravel's Gate.
        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission, function ($user) {
                return  ! is_null($user->agency);
            });
        }

        Gate::define('add_project', function ($user) {
            return  ! is_null($user->agency);
        });

        Gate::define('manage_project', function ($user, $project) {
            return $user->id == $project->owner_id;
        });

        Gate::define('manage_features', function ($user, $project) {
            return $user->id == $project->owner_id;
        });

        Gate::define('manage_feature', function ($user, $feature) {
            return $user->id == $feature->worker_id;
        });
    }

    /**
     * Fetch the collection of site permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPermissions()
    {
        return [
            'manage_users',
            'manage_role_permissions',
            'manage_backups',
            'manage_options',
            'manage_projects',
            'manage_payments',
            'manage_subscriptions',
            'see_reports',
        ];
    }
}
