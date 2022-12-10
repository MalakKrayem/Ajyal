<?php

namespace App\Listeners;

use App\Models\Course;
use App\Events\AchievementAdded;
use App\Models\Mentor;
use App\Notifications\AchievementAdded as NotificationsAchievementAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddAchievement
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
     * @param  \App\Events\AchievementAdded  $event
     * @return void
     */
    public function handle(AchievementAdded $event)
    {
        //
        $ach = $event->freelance;

        $course = Course::with('group')->whereHas('group', function ($query) use ($ach) {
            $query->where('group_id', $ach->group_id);
        })->first();
        
        $mentor=Mentor::findOrFail($course->mentor_id);

        $mentor->notify(new NotificationsAchievementAdded($event->freelance));
    }
}