<?php

namespace App\Listeners;

use App\Events\UserNotification;
use App\Models\Events\EventGuests;
use App\Models\Fundings\FundingCollection;
use App\Models\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserNotification
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
     * @param  \App\Events\UserNotification  $event
     * @return void
     */
    public function handle(UserNotification $event)
    {
        $action = $event->action;
        $object = $event->object ;
        dd($object);
        if ( $object instanceof EventGuests ) {

        }elseif ( $object instanceof FundingCollection  ) {

        } else {

        }
        foreach ( $event->getGuests as $guest ) {
            $event_notification = new Notification();
            $event_notification->user_type = 'user';
            if($action == 'created') {
                $event_notification->title = 'New Event Created';
                $event_notification->description = 'A New Event '.$event->name.' is Created with status '.$event->status;
            } else {
                $event_notification->title = 'Event Updated';
                $event_notification->description = 'An Event '.$event->name.' is Updated with status '.$event->status;
            }
            $event_notification->user_id = $guest->user_id;
            $event->notifications()->save($event_notification);
        }
        foreach ( $event->fundingCollections as $fundingCollection ) {
            $event_notification = new Notification();
            $event_notification->user_type = 'user';
            if($action == 'created') {
                $event_notification->title = 'New Event Created';
                $event_notification->description = 'A New Event '.$event->name.' is Created with status '.$event->status;
            } else {
                $event_notification->title = 'Event Updated';
                $event_notification->description = 'An Event '.$event->name.' is Updated with status '.$event->status;
            }
            $event_notification->user_id = $fundingCollection->user_id;
            $event->notifications()->save($event_notification);
        }
    }
}
