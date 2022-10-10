<?php

namespace App\Listeners;

use App\Events\UpdateStudentJobs;
use App\Models\Student;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStudentJobsListener
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
    public function handle(UpdateStudentJobs $event)
    {
        $student=$event->student;
        $value=$event->value;
        $student=Student::where('id','=',$student)->first();
        $student->total_jobs=$student->total_jobs+$value;
        $student->save();
    }
}
