<?php

namespace App\Observers;

use App\Models\Fundings\FundingCollection;

class FundingCollectionObserver
{
    /**
     * Handle the FundingCollection "created" event.
     *
     * @param  \App\Models\Fundings\FundingCollection  $fundingCollection
     * @return void
     */
    public function created(FundingCollection $fundingCollection)
    {
        if( $fundingCollection->event->status == 'active' || $fundingCollection->event->status == 'finished' || $fundingCollection->funding_type_id > 0) {
            event(new userNotification($fundingCollection, 'created'));
        }
    }

    /**
     * Handle the FundingCollection "updated" event.
     *
     * @param  \App\Models\Fundings\FundingCollection  $fundingCollection
     * @return void
     */
    public function updated(FundingCollection $fundingCollection)
    {
        if( $fundingCollection->event->status == 'active' || $fundingCollection->event->status == 'finished' || $fundingCollection->funding_type_id > 0 ) {
            event(new userNotification($fundingCollection, 'updated'));
        }
    }

    /**
     * Handle the FundingCollection "deleted" event.
     *
     * @param  \App\Models\Fundings\FundingCollection  $fundingCollection
     * @return void
     */
    public function deleted(FundingCollection $fundingCollection)
    {
        //
    }

    /**
     * Handle the FundingCollection "restored" event.
     *
     * @param  \App\Models\Fundings\FundingCollection  $fundingCollection
     * @return void
     */
    public function restored(FundingCollection $fundingCollection)
    {
        //
    }

    /**
     * Handle the FundingCollection "force deleted" event.
     *
     * @param  \App\Models\Fundings\FundingCollection  $fundingCollection
     * @return void
     */
    public function forceDeleted(FundingCollection $fundingCollection)
    {
        //
    }
}
