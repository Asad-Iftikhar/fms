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
use App\Mail\RemindMail;

class RemindAllParticipants implements ShouldQueue
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
        if ( $event = Event::find( $this->event_id ) ) {
            if ($event->fundingCollections->count() > 0) {
                foreach ($event->fundingCollections as $fundingCollection) {
                    if($fundingCollection->is_received == 0){
                        $fundingCollection->is_reminded = 1;
                        $fundingCollection->last_reminded = Carbon::now()->toDateTimeString();
                        if( $fundingCollection->save() ) {
                            $fundingCollection->name = $fundingCollection->user->getFullName();
                            $fundingCollection->title = $fundingCollection->getCollectionTitle();
                            $fundingCollection->amount = $fundingCollection->amount;
                            try {
                                //Email sending
                                Mail::to($fundingCollection->user->email)->send(new RemindMail($fundingCollection));
                            } catch (\Exception $e) {

                            }
                        }
                    }
                }
            }
        }
    }
}
