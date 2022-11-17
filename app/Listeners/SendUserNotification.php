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
        $notification = new Notification();
        $notification->user_type = 'user';
        if ( $object instanceof EventGuests ) {
            if($action == 'created') {
                $notification->title = 'Event Invitation';
                $notification->description = 'You are Invited to '.$object->event->name.' which is to take place on '. $object->$event->event_date;
                $notification->user_id = $object->user_id;
                $object->notifications()->save($notification);
            }
        } elseif ( $object instanceof FundingCollection  ) {
            if($action == 'created') {
                $notification->title = 'New Collection Created';
                $notification->description = 'A New Collection with amount '.$object->amount;
            } else {
                $notification->title = 'Collection Updated';
                $notification->description = 'Your Collection with title '.$object->getCollectionTitle().' is updated.';
            }
            $notification->user_id = $object->user_id;
            $object->notifications()->save($notification);
        } else {

        }
    }
}
