<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\QueryCaptured;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessQuery
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(QueryCaptured $event)
    {
        // Lakukan sesuatu dengan query
        Log::info("User Query: " . $event->query);

        // Jika model membutuhkan, Anda bisa membuat custom logika di sini.
    }
}
