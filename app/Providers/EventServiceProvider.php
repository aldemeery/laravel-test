<?php

namespace App\Providers;

use App\Events\ModelDisqualified;
use App\Events\ModelQualified;
use App\Events\ModeratedModelCreated;
use App\Listeners\ApproveModel;
use App\Listeners\ModerateModel;
use App\Listeners\RejectModel;
use App\Listeners\SendRejectionNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
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
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ModeratedModelCreated::class => [
            ModerateModel::class,
        ],
        ModelQualified::class => [
            ApproveModel::class,
        ],
        ModelDisqualified::class => [
            RejectModel::class,
            SendRejectionNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
