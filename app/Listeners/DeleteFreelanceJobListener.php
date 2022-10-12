<?php

namespace App\Listeners;

use App\Events\DeleteFreelanceJob;
use App\Events\UpdatePlatformJobsCount;
use App\Events\UpdateStudentIncome;
use App\Events\UpdateStudentJobs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteFreelanceJobListener
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
    public function handle(DeleteFreelanceJob $event)
    {
        $freelance=$event->freelance;
        event(new UpdateStudentJobs($freelance->student_id,-1));
        event(new UpdateStudentIncome(-$freelance->salary,$freelance->student_id,null));
        event(new UpdatePlatformJobsCount($freelance->platform_id,-1));
    }
}
