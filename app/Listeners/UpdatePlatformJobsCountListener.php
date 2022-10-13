<?php

namespace App\Listeners;

use App\Events\UpdatePlatformJobsCount;
use App\Models\Platform;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdatePlatformJobsCountListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(UpdatePlatformJobsCount $event)
    {
        //Multiple events type
        $platform=$event->platform;
        $value=$event->value;
        $platform=Platform::find($platform);
        $platform->jobs_count=$platform->jobs_count+$value;
        $platform->save();

    }
}
