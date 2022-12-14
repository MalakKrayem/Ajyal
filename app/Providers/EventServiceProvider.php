<?php

namespace App\Providers;

use App\Events\AchievementAdded;
use App\Events\DeleteFreelanceJob;
use App\Events\ProjectPartnerEvent;
use App\Events\StudentAdded;
use App\Events\StudentGroupEvent;
use App\Events\UpdatePlatformJobsCount;
use App\Events\UpdateStudentIncome;
use App\Events\UpdateStudentJobs;
use App\Events\UpdateStudentRate;
use App\Listeners\AddAchievement;
use App\Listeners\AddStudent;
use App\Listeners\DeleteFreelanceJobListener;
use App\Listeners\ProjectPartnerRelation;
use App\Listeners\StudentGroupRelation;
use App\Listeners\UpdatePlatformJobsCountListener;
use App\Listeners\UpdateStudentIncomeListener;
use App\Listeners\UpdateStudentJobsListener;
use App\Listeners\UpdateStudentRateListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProjectPartnerEvent::class => [
            ProjectPartnerRelation::class,
        ],
        StudentGroupEvent::class=>[
            StudentGroupRelation::class,
        ],
        UpdateStudentJobs::class=>[
            UpdateStudentJobsListener::class
        ],
        UpdateStudentIncome::class=>[
            UpdateStudentIncomeListener::class
        ],
        UpdatePlatformJobsCount::class=>[
            UpdatePlatformJobsCountListener::class
        ],
        DeleteFreelanceJob::class=>[
            DeleteFreelanceJobListener::class
        ],
        UpdateStudentRate::class=>[
            UpdateStudentRateListener::class,
        ],
        AchievementAdded::class=>[
            AddAchievement::class,  
        ],
        StudentAdded::class=>[
            AddStudent::class,  
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}