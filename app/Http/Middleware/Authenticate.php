<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        if ( Auth::guard( $guard )->guest() ) {
            if ( $request->ajax() || $request->wantsJson() ) {
                return response( 'Unauthorized.', 401 );
            } else {
                // Store the current uri in the session
                if ( $request->is( '/' ) ) {
                    $request->session()->put( 'url.intended', 'account' );
                } else {
                    $request->session()->put( 'url.intended', $request->url() );
                }
                // Redirect to the login page
                return redirect()->guest( 'account/login' );
            }
        }
        return $next( $request );
    }


}
