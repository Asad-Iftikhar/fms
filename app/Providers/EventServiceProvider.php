<?php

namespace App\Providers;

use App\Events\EventNotification;
use App\Listeners\SendEventNotification;
use App\Models\Events\Event;
use App\Models\Events\EventGuests;
use App\Models\Fundings\FundingCollection;
use App\Observers\EventGuestsObserver;
use App\Observers\EventObserver;
use App\Observers\FundingCollectionObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        EventNotification::class => [
            SendEventNotification::class,
        ],
        UserNotification::class => [
            SendUserNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::observe(EventObserver::class);
        FundingCollection::observe(FundingCollectionObserver::class);
        EventGuests::observe(EventGuestsObserver::class);
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
