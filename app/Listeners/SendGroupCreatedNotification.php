<?php

namespace App\Listeners;

use App\Events\GroupCreated;
use App\Models\Student;
use App\Notifications\GroupCreateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendGroupCreatedNotification
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
    public function handle(GroupCreated $event)
    {
        $group = $event->group;

        $students = Student::where('student_id','!=', $group->student_id)->get();
        Notification::send($students, new GroupCreateNotification($group));
    }
}
