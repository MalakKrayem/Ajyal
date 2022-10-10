<?php

namespace App\Providers;

use App\Events\IncreasePlatformJobsCount;
use App\Events\IncreaseStudenIncome;
use App\Events\IncreaseStudenJobs;
use App\Events\ProjectPartnerEvent;
use App\Events\StudentGroupEvent;
use App\Events\UpdateStudentRate;
use App\Listeners\IncreasePlatformJobsCountListener;
use App\Listeners\IncreaseStudenIncomeListener;
use App\Listeners\IncreaseStudenJobsListener;
use App\Listeners\ProjectPartnerRelation;
use App\Listeners\StudentGroupRelation;
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
        IncreaseStudenJobs::class=>[
            IncreaseStudenJobsListener::class,
        ],
        IncreaseStudenIncome::class=>[
            IncreaseStudenIncomeListener::class,
        ],
        IncreasePlatformJobsCount::class=>[
            IncreasePlatformJobsCountListener::class,
        ],
        UpdateStudentRate::class=>[
            UpdateStudentRateListener::class,
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
