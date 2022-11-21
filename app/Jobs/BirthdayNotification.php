<?php

namespace App\Jobs;

use App\Models\Notifications\Notification;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BirthdayNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $birthday_users = User::where('activated', 1)->whereDate('dob', Carbon::today())->get();
        $birthday_users = User::where('activated', 1)->get();
        if( $birthday_users->count() > 0 ){
            foreach ($birthday_users as $bday_user) {
                $notification = new Notification();
                $notification->user_type = 'user';
                $notification->title = 'Happy Birthday';
                $notification->description = 'A Very Happy Birthday to you  '.$bday_user->getFullName();
                $notification->user_id = $bday_user->id;
                $bday_user->notifications()->save($notification);
                $admin_notification = new Notification();
                $admin_notification->user_type = 'admin';
                $admin_notification->title = 'Employee Birthday';
                $admin_notification->description = 'Dear Admin Today is Birthday of '.$bday_user->getFullName();
                $bday_user->notifications()->save($admin_notification);
            }
        }
    }
}
