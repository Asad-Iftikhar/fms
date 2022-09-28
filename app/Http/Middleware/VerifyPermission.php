<?php namespace App\Http\Middleware;

use App\Mail\Auth\TwoFACode;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Mail;

class VerifyPermission {

    protected $except = [
        //
    ];

    /**
     * Run the request filter.
     *
     * @param \Request $request
     * @param \Closure $next
     * @param string $permission
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function handle($request, Closure $next, $permission = null) {
        if ( !Auth::check() ) {
            if ( $request->ajax() ) {
                return response( 'Unauthorized.', 401 );
            }
            // Store the current uri in the session
            $request->session()->put( 'url.intended', $request->url() );

            // Redirect to the login page
            return redirect( 'account/login' );

        }

        $Permissions = explode( '|', $permission );
        if ( !Auth::user()->can( $Permissions ) ) {
            throw new AuthorizationException( 'You Do Not Have Sufficient Permission to Access This Page' );
        }

        return $next( $request );
    }

}