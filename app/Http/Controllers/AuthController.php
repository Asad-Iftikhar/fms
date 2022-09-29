<?php

namespace App\Http\Controllers;

use App\Jobs\LogEvent;
use App\Models\Users\User;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestInstance;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Get Login Page View
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        return view( 'site.account.login' );
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postLogin(Request $request) {
        // Declare the rules for the form validation
        $rules = array (
            'username' => 'string|required',
            'password' => 'string|required'
        );

        // Validate the inputs
        $validator = Validator::make( request()->all(), $rules );
        // Check if the form validates with success
        if ( $validator->passes() ) {

            $throttler = Throttle::get( RequestInstance::instance(), 5, 5 );
            if ( !$throttler->attempt() ) {
                return redirect( 'account/login' )->with( 'error', 'Too many incorrect attempts. Please try again later.');
            }

            $RememberMe = request()->filled( 'remember-me' );

            $field = filter_var( request()->input( 'username' ), FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';
            // Try to log the user in
            if ( Auth::attempt( array($field => request()->input( 'username' ), 'password' => request()->input( 'password' ), 'activated' => 1, 'disabled' => 0), $RememberMe ) ) {
                $request->session()->regenerate();
                $throttler->clear( $request );

                Auth::logoutOtherDevices( request()->input( 'password' ) );
                return redirect()->intended( 'account' )->with( 'success', trans( 'account/auth.messages.login.success' ) );
            }
            // Login User And Redirect to Last URI OR User Dashboard
        }
        // Something went wrong
        return redirect( 'account/login' )->withInput()->withErrors( $validator );
    }

    /**
     * Forgot password page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getForgetPassword () {
        # Check Login
        # Else Load view
    }

    /**
     * Forgot password form processing page.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function postForgotPassword(Request $request) {
        // Declare the rules for the validator
        $rules = array(
            'email' => 'required|email'
        );

        # Throttle Attempts Limit
        # Send Link to Reset Password with Random Token : account/forgot-password/{resetCode}

    }

    /**
     * Forgot Password Confirmation page.
     *
     * @param string|null $resetCode
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getForgotPasswordConfirmation($resetCode = null) {
        try {
            if ( $user = User::where( 'reminder_code', '=', $resetCode )->first() ) {
                if ( $user->checkResetPasswordCode( $resetCode ) ) {
                    return view( 'site/account/forgot-password-confirmation' );
                }
                //Reset Code Not Valid
                return redirect( 'account/forgot-password' )->with( 'error', 'Reset password code is invalid. Checked' );
            }
            //User Not Found
            return redirect( 'account/forgot-password' )->with( 'error', 'The reset password link you are trying to use has expired. Please try resetting your password again.' );
        } catch (\Exception $e) {
            // Redirect to the forgot password page
            return redirect( 'account/forgot-password' )->with( 'error', 'This user account was not found.' );
        }
    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param string|null $resetCode
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postForgotPasswordConfirmation($resetCode = null) {
        // Declare the rules for the form validation
        $rules = array(
            'password' => 'required|between:3,32|confirmed',
            'password_confirmation' => 'required'
        );

        // Validate the inputs
        $validator = Validator::make( request()->all(), $rules );

        // Check if the form validates with success
        if ( $validator->passes() ) {

        }
    }

    /**
     * Reset password page.
     * For when Require_PW_Change is flagged
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getResetPassword() {
        // Are we logged in?
        if ( Auth::check() ) {
            $User = Auth::user();
            // Show the page
            return view( 'site/account/reset-password' );
        }
        return redirect( 'account/login' )->with( 'error', 'You must be logged in to reset your password.' );
    }

    /**
     * Reset Password form processing page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postResetPassword() {
        if ( Auth::check() ) {
            // Declare the rules for the form validation
            $rules = array(
                'password' => 'required|between:3,32|confirmed',
                'password_confirmation' => 'required'
            );
            // Validate the inputs
            $validator = Validator::make( request()->all(), $rules );
            // Check if the form validates with success
            if ( $validator->passes() ) {
                if ( $user = Auth::user() ) {
                    $user->password = request()->input('password');
                    if ( $user->save() ) {
                        Auth::logoutOtherDevices( request()->input( 'password' ) );
                        # User Password History
                        return redirect( 'account' )->with( 'success', 'Password successfully reset' );
                    }
                }
            }
        }
    }

    /**
     * Logout page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout() {
        // Log the user out
        Auth::logout();
        session()->invalidate();
        // Redirect to the users page
        return redirect( 'account/login' )->with( 'success', 'You have successfully logged out!' );
    }

}
