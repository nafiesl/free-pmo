<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Projects\Created' => [
            'App\Listeners\Projects\LogProjectCreationActivity',
        ],
        'App\Events\Projects\Updated' => [
            'App\Listeners\Projects\LogProjectUpdateActivity',
        ],
        'App\Events\Jobs\Created'     => [
            'App\Listeners\Jobs\LogJobCreationActivity',
        ],
        'App\Events\Jobs\Updated'     => [
            'App\Listeners\Jobs\LogJobUpdateActivity',
        ],
        'App\Events\Jobs\Deleted'     => [
            'App\Listeners\Projects\LogProjectJobDeletionActivity',
        ],
        'App\Events\Tasks\Created'    => [
            'App\Listeners\Tasks\LogTaskCreationActivity',
        ],
        'App\Events\Tasks\Updated'    => [
            'App\Listeners\Tasks\LogTaskUpdateActivity',
        ],
        'App\Events\Tasks\Deleted'    => [
            'App\Listeners\Jobs\LogJobTaskDeletionActivity',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
