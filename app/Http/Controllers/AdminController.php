<?php namespace App\Http\Controllers;

use App\Jobs\Mailer\SendQueuedMail;
use App\Mail\ActivityPlan\ActivityNoteCreated;
use App\Models\ActivityNote;
use App\Models\ActivityPlan;
use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\MultiMedia\S3;
use App\Models\MultiMedia\Video;
use Illuminate\Support\Str;
use League\Flysystem\FilesystemException;

class AdminController extends AuthorizedController {

    public function __construct() {
        parent::__construct();

        // Apply the auth filter
        $this->middleware( 'permission:admin' );

    }
}
