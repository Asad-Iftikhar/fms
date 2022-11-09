<?php

namespace App\Listeners;

use App\Events\EventNotification;
use App\Models\Events\Event;
use App\Models\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEventNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EventNotification  $event
     * @return void
     */
    public function handle(EventNotification $event)
    {
        $event = $event->event ;
        foreach ( $event->getGuests as $guest ) {
            $event_notification = new Notification();
            $event_notification->user_type = 'user';
            $event_notification->title = 'New Event Activated';
            $event_notification->description = 'A New Event '.$event->name.' is Activated & you are Invited as a guest to it';
            $event_notification->user_id = $guest->user_id;
            $event->notifications()->save($event_notification);
        }
        foreach ( $event->fundingCollections as $fundingCollection ) {
            $event_notification = new Notification();
            $event_notification->user_type = 'user';
            $event_notification->title = 'New Event Activated';
            $event_notification->description = 'A New Event '.$event->name.' is Activated & you are participant of it';
            $event_notification->user_id = $fundingCollection->user_id;
            $event->notifications()->save($event_notification);
            $collection_notification = new Notification();
            $collection_notification->user_type = 'user';
            $collection_notification->title = 'New Collection Created';
            $collection_notification->description = 'A New Collection is Created with amount "' . $fundingCollection->amount . '".';
            $collection_notification->user_id = $fundingCollection->user_id;
            $fundingCollection->notifications()->save($collection_notification);
        }

    }
}
