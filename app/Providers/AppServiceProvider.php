<?php

namespace Csvimport\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

//        Queue::after(function (JobProcessed $event) {
//            // $event->connectionName
//            // $event->job
//            // $event->job->payload()
//        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
