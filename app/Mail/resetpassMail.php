<?php

namespace App\Mail;

use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resetpassMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public $HashedToken;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {

        $this->user = $user;
        $this->HashedToken = $this->user->generateResetToken();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset Password')->markdown('emails.forgetPasswordEmail');
    }
}
