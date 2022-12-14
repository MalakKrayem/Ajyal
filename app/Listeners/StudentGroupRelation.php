<?php

namespace App\Listeners;

use App\Events\StudentAdded;
use App\Events\StudentGroupEvent;
use App\Models\StudentGroup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StudentGroupRelation
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
     * @param  \App\Events\StudentGroupEvent  $event
     * @return void
     */
    public function handle(StudentGroupEvent $event)
    {
        $student = $event->student;
        $group = $event->group;
        StudentGroup::create([
            'student_id' => $student,
            'group_id' => $group
        ]);

        // event(new StudentAdded($student));
    }
}