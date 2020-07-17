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
        'App\Entities\Partners\Vendor'   => 'App\Policies\Partners\VendorPolicy',
        'App\Entities\Partners\Customer' => 'App\Policies\Partners\CustomerPolicy',
        'App\Entities\Projects\Project'  => 'App\Policies\Projects\ProjectPolicy',
        'App\Entities\Projects\Comment'  => 'App\Policies\Projects\CommentPolicy',
        'App\Entities\Projects\Job'      => 'App\Policies\Projects\JobPolicy',
        'App\Entities\Projects\Issue'    => 'App\Policies\Projects\IssuePolicy',
        'App\Entities\Projects\Task'     => 'App\Policies\Projects\TaskPolicy',
        'App\Entities\Payments\Payment'  => 'App\Policies\PaymentPolicy',
        'App\Entities\Users\User'        => 'App\Policies\UserPolicy',
        'App\Entities\Users\Event'       => 'App\Policies\EventPolicy',
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
                return $user->hasRole('admin');
            });
        }

        Gate::define('manage_jobs', function ($user, $project) {
            return true;
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
            'manage_agency',
            'manage_options',
            'manage_payments',
            'manage_subscriptions',
        ];
    }
}
