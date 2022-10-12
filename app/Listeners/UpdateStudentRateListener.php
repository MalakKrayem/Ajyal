<?php

namespace App\Listeners;

use App\Events\UpdateStudentRate;
use App\Models\Rate;
use App\Models\Student;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStudentRateListener
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
    public function handle(UpdateStudentRate $event)
    {
        $student=$event->student;
        $old_rate=$event->old_rate;
        $new_rate=$event->new_rate;
        if(($old_rate == null && $new_rate == null) || ($old_rate != $new_rate)){
            $rate=Rate::where('student_id','=',$student)->avg('rate');
            $student=Student::find($student);
            $student->rate=$rate;
            $student->save();
        }

    }
}
