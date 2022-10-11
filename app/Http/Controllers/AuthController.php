<?php

namespace App\Http\Controllers;

use App\Jobs\LogEvent;
use App\Mail\resetpassMail;
use App\Models\Users\User;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestInstance;
use Illuminate\Support\Facades\Validator;
use Mail;

class AuthController extends Controller
{
    protected $maxAttempts = 5;

    /**
     * Get Login Page View
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        // Are we logged in?
        if ( Auth::check() ) {
            return redirect( 'account' );
        }
        // Show the page
        return view( 'site.account.login' );
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postLogin(Request $request) {
        // Declare the rules for the form validation
        $rules = array(
            'username' => 'required|string',
            'password' => 'required|string'
        );
        // Validate the inputs
        $validator = Validator::make(request()->all(), $rules);
        // Check if the form validates with success
        if ( $validator->passes() ) {
            $field = filter_var(request()->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            if( empty(User::where($field, $request->input('username'))->first()) ) {
                return redirect()->back()->withErrors(['email' => 'User does not exist']);
            }
            $throttler = Throttle::get(RequestInstance::instance(), $this->maxAttempts, 5);
            if ( !$throttler->attempt() ) {
                return redirect()->back()->withErrors(['error' => 'Too many incorrect attempts. Please try again later.']);
            }
            $RememberMe = request()->filled('remember-me');

            // Try to log the user in
            if ( Auth::attempt(array($field => request()->input('username'), 'password' => request()->input('password'), 'activated' => 1, 'disabled' => 0), $RememberMe)) {
                $request->session()->regenerate();
                $throttler->clear($request);
                Auth::logoutOtherDevices(request()->input('password'));
                return redirect()->intended('account')->with('success', 'You have successfully logged in.');
            }
        }
        // Something went wrong
        return redirect('account/login')->withInput()->withErrors($validator);
    }

    /**
     * Forgot password page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getForgetPassword(Request $request)
    {
        # Check Login
        if (Auth::check()) {
            return redirect('account');
        } else {
            //return redirect('account/forgot-password');
            return view('site.account.forgot_password');
        }
    }

    /**
     * Forgot password form processing page.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function postForgotPassword(Request $request) {
        //You can add validation login here
        $user = User::where('email', $request->email)->first();
        //rules for email pattern
        $rules = [
            'email' => 'required|email'
        ];
        //validation for email pattern
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->messages());
        }
        //Check if the user exists
        if (!$user) {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        if($user->save()) {
            try {
                //Email sending
                Mail::to($user->email)->send(new resetpassMail($user));
                return redirect()->back()->with('success', trans('Successfully sent e-mail'));
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['email' => trans('There is something wrong, Please try again.')]);
            }
        }
    }

    /**
     * Reset password page.
     * For when Require_PW_Change is flagged
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getResetPassword($token){
        // User Auth Login
        if($user = User::where('reset_token', $token)->get()->first()) {
            // load view
            return view('site.account.change_password', compact('user', 'token'));
        } else {
            // invalid token
            return redirect('account/forgot_password')->with('fail', 'Password Changed');
        }
    }

    /**
     * Reset Password form processing page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postResetPassword($token){
        if ($token) {
            // Declare the rules for the form validation
            $rules = array(
                'password' => 'required|between:3,32|confirmed',
                'password_confirmation' => 'required'
            );
            //confirm password validation

            // Validate the inputs
            $validator = Validator::make(request()->all(), $rules);
            // Check if the form validates with success
            if ($validator->passes()) {
                // Validate the token
                if ($user = User::where('reset_token', $token)->get()->first()) {
                    $user->password = bcrypt(request()->input('password'));
                    $user->reset_token = null;
                    if ($user->save()) {
                        # User Password History
                        return redirect('account/login')->with('status', 'Password successfully reset');
                    }
                }
            }
            else{
                    return back()->withInput()->withErrors($validator->messages());
            }
            return redirect('account/reset-password/'. $token)->with('error', 'Something went wrong');
        } else {
            return redirect('account/forgot-password'. $token)->with('error', 'Token required!');
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
        return redirect('account/login')->with('success', 'You have successfully logged out!');
    }
}
