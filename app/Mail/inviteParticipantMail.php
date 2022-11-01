<?php

namespace App\Mail;

use App\Models\Fundings\FundingCollection;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class inviteParticipantMail extends Mailable
{
    use Queueable, SerializesModels;
    public FundingCollection $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {

        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Event Invitation')->markdown('emails.inviteEmail');
    }
}
