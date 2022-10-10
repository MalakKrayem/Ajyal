<?php

namespace App\Listeners;

use App\Events\UpdateStudentIncome;
use App\Models\Student;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStudentIncomeListener
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
    public function handle(UpdateStudentIncome $event)
    {
        $salary=$event->salary;
        $student=$event->student;
        $student=Student::find($student);
        $student->total_income=$student->total_income +$salary;
        $student->save();
    }
}
