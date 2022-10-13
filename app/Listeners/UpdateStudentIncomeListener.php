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
        $old_salary=$event->old_salary;
        $student=Student::find($student);

        //if($old_salary == null && $salary != null){
            $student->total_income=$student->total_income -floatval($event->old_salary) +$salary;
            $student->save();
        // }elseif($old_salary != null && $old_salary != $salary){
        //     $diff=$salary-$old_salary;
        //     $student->total_income=$student->total_income +$diff;
        //     $student->save();
        // }
    }
}
