<?php

namespace App\Mail;

use App\Models\Events\EventGuests;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class inviteGuestMail extends Mailable
{
    use Queueable, SerializesModels;
    public EventGuests $data;

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
