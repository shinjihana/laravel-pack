<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Illuminate\Auth\Events\Registered;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Happy\ThreadMan\Events\ThreadReceiveNewReply' => [
            'Happy\ThreadMan\Listeners\NotifyMentionedUsers',
            'Happy\ThreadMan\Listeners\NotifySubscribers',
        ],

        Registered::class => [
            'Happy\ThreadMan\Listeners\SendEmailConfirmationRequest'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
