<?php

namespace App\Observers;

use App\Models\Events\EventGuests;
use App\Events\UserNotification;

class EventGuestsObserver
{
    /**
     * Handle the EventGuests "created" event.
     *
     * @param  EventGuests  $eventGuest
     * @return void
     */
    public function created(EventGuests $eventGuest)
    {
        if( $eventGuest->event->status == 'active' || $eventGuest->event->status == 'finished') {
            event(new userNotification($eventGuest, 'created'));
        }
    }

    /**
     * Handle the EventGuests "updated" event.
     *
     * @param  \App\Models\EventGuests  $eventGuests
     * @return void
     */
    public function updated(EventGuests $eventGuests)
    {
        //
    }

    /**
     * Handle the EventGuests "deleted" event.
     *
     * @param  \App\Models\EventGuests  $eventGuests
     * @return void
     */
    public function deleted(EventGuests $eventGuests)
    {
        //
    }

    /**
     * Handle the EventGuests "restored" event.
     *
     * @param  \App\Models\EventGuests  $eventGuests
     * @return void
     */
    public function restored(EventGuests $eventGuests)
    {
        //
    }

    /**
     * Handle the EventGuests "force deleted" event.
     *
     * @param  \App\Models\EventGuests  $eventGuests
     * @return void
     */
    public function forceDeleted(EventGuests $eventGuests)
    {
        //
    }
}
