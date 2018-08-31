<?php

namespace Csvimport\Listeners;

use Csvimport\Events\ImportFinished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImportEvent implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ImportFinished  $event
     * @return void
     */
    public function handle(ImportFinished $event)
    {
        //
    }
}
