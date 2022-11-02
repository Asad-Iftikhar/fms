<?php

namespace App\Jobs;

use App\Models\Events\Event;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\InviteGuestMail;
use App\Mail\InviteParticipantMail;

class InviteAllParticipants implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $event_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if ( $event = Event::find($this->event_id ) ) {
                if ($event->fundingCollections->count() > 0 || $event->getGuests->count() > 0) {
                    foreach ($event->fundingCollections as $fundingCollection) {
                        $fundingCollection->is_invited = 1;
                        $fundingCollection->last_invited = Carbon::now()->toDateTimeString();
                        if( $fundingCollection->save() ) {
                            $fundingCollection->name = $fundingCollection->user->getFullName();
                            $fundingCollection->event_name = $fundingCollection->getEvent();
                            $fundingCollection->desc = (empty($fundingCollection->event->description) ? 'N/A' : $fundingCollection->event->description );
                            $fundingCollection->date = (empty($fundingCollection->event->event_date) ? 'To be Decided' : $fundingCollection->event->event_date );
                            Mail::to($fundingCollection->user->email)->send(new InviteParticipantMail($fundingCollection));
                        }
                    }
                }
                if ($event->getGuests->count() > 0) {
                    foreach ($event->getGuests as $guest) {
                        $guest->is_invited = 1;
                        $guest->last_invited = Carbon::now()->toDateTimeString();
                        if( $guest->save() ) {
                            $guest->name = $guest->user->getFullName();
                            $guest->event_name = $guest->event->name;
                            $guest->desc = (empty($guest->event->description) ? 'N/A' : $guest->event->description );
                            $guest->date = (empty($guest->event->event_date) ? 'To be Decided' : $guest->event->event_date );
                            Mail::to($guest->user->email)->send(new InviteGuestMail($guest));
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
        }
    }
}
