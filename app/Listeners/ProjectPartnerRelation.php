<?php

namespace App\Listeners;

use App\Events\ProjectPartnerEvent;
use App\Models\ProjectPartner;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProjectPartnerRelation
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
     * @param  \App\Events\ProjectPartnerEvent  $event
     * @return void
     */
    public function handle(ProjectPartnerEvent $event)
    {
        $project = $event->project;
        $partner = $event->partner;
        ProjectPartner::create([
            'project_id' => $project,
            'partner_id' => $partner
        ]);
    }
}
