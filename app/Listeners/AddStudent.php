<?php

namespace App\Listeners;

use App\Models\Course;
use App\Models\Mentor;
use App\Events\StudentAdded;
use App\Notifications\StudentAdded as NotificationsStudentAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddStudent
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
     * @param  \App\Events\StudentAdded  $event
     * @return void
     */
    public function handle(StudentAdded $event)
    {
        //
        $student=$event->studentGroup;
        $group=$event->group_id;
        
        $course= Course::with('group')->whereHas('group', function ($query) use ($group) {
            $query->where('group_id', $group);
        })->first();

    
        $mentor = Mentor::findOrFail($course->mentor_id);

        $mentor->notify(new NotificationsStudentAdded($event->studentGroup,$event->group_id));
    }
}