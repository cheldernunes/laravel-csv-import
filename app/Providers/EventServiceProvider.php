<?php

namespace Csvimport\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Csvimport\Events\Event' => [
            'Csvimport\Listeners\EventListener',
            'Csvimport\Listeners\ImportEvent',
        ]
//        'Csvimport\Events\ImportFinished' => [
//            'Csvimport\Listeners\ImportEvent',
//        ],
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
