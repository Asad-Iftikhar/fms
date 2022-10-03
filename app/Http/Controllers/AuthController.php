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
use Illuminate\Support\Str;
use DB;
use Mail;

class AuthController extends Controller
{
    protected $maxattempts = 3;

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
    public function postLogin(Request $request)
    {
        // Declare the rules for the form validation
        $rules = array(
            'username' => 'string|required',
            'password' => 'string|required'
        );

        // Validate the inputs
        $validator = Validator::make(request()->all(), $rules);
        // Check if the form validates with success
        if ($validator->passes()) {

            $throttler = Throttle::get(RequestInstance::instance(), 5, 5);
            if (!$throttler->attempt()) {
                return redirect('account/login')->with('error', 'Too many incorrect attempts. Please try again later.');
            }

            $RememberMe = request()->filled('remember-me');

            $field = filter_var(request()->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            // Try to log the user in
            if (Auth::attempt(array($field => request()->input('username'), 'password' => request()->input('password'), 'activated' => 1, 'disabled' => 0), $RememberMe)) {
                $request->session()->regenerate();
                $throttler->clear($request);

                Auth::logoutOtherDevices(request()->input('password'));
                return redirect()->intended('account')->with('success', trans('account/auth.messages.login.success'));
            }
            // Login User And Redirect to Last URI OR User Dashboard
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
        if (!Auth::check()) {
            return redirect('account/login');
        } else {
            # Else Load view
            //return redirect('account/forgot-password');
            return view('site.account.forgot_password');
        }
    }

    /**
     * Forgot password form processing page.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function postForgotPassword(Request $request)
    {


        //You can add validation login here
        $user = User::where('email', $request->email)->first();
        //Check if the user exists
        if (!$user) {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        $user->reset_token = 'hannan'.Str::random(60);
//        dd($user);
        if($user->save()) {
            try {
                //Here send the link with an external email API
                Mail::send(new resetpassMail($user), function ($message) use ($user) {
                    $message->from('fms.local@email.com');
                    $message->to($user->email);
                    $message->subject('Reset Password');
                });
                if (Mail::failures()) {
                    return response()->Fail('Sorry! Please try again latter');
                } else {
                    //dd($link);
                }
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }

        # Throttle Attempts Limit
        # Send Link to Reset Password with Random Token : account/forgot-password/{resetCode}

    }

    /**
     * Forgot Password Confirmation page.
     *
     * @param string|null $resetCode
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getForgotPasswordConfirmation($email, $token)
    {
        //Retrieve the user from the database
        $user = DB::table('users')->where('email', $email)->select('email')->first();
        //Generate, the password reset link. The token generated is embedded in the link

    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param string|null $resetCode
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postForgotPasswordConfirmation(Request $request)
    {
        // Declare the rules for the form validation
        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'confirmPassword' => '',
            'token' => 'required']);

        // Check if the form validates with success
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        }

        $password = $request->password;

        // Validate the token
        $tokenData = DB::table('password_resets')->where('token', $request->token)->first();

        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return redirect('account/forgot-password');

        $user = User::where('email', $tokenData->email)->first();

        // Redirect the user back if the email is invalid
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);

        //Hash and update the new password
        $user->password = \Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        Auth::login($user);
        //Delete the token
        DB::table('password_resets')->where('email', $user->email)->delete();
        //Send Email Reset Success Email
        if ($this->sendSuccessEmail($tokenData->email)) {
            return redirect('index');
        } else {
            return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        }

    }

    /**
     * Reset password page.
     * For when Require_PW_Change is flagged
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getResetPassword($token)
    {
        // Are we logged in?
        if (Auth::check()) {
            $User = Auth::user();
            // Show the page
            return view('site/account/change_password');
        }

        if($user = User::where('token', $token)->first())
        return redirect('account/login')->with('error', 'You must be logged in to reset your password.');
    }

    /**
     * Reset Password form processing page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postResetPassword()
    {

        // Declare the rules for the form validation
        $rules = array(
            'password' => 'required|between:3,32|confirmed',
            'password_confirmation' => 'required'
        );
        // Validate the inputs
        $validator = Validator::make(request()->all(), $rules);
        // Check if the form validates with success
        if ($validator->passes()) {
            if ($user = Auth::user()) {
                $user->password = request()->input('password');
                if ($user->save()) {
                    Auth::logoutOtherDevices(request()->input('password'));
                    # User Password History
                    return redirect('account')->with('success', 'Password successfully reset');
                }
            }
        }
    }

    /**
     * Logout page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        // Log the user out
        Auth::logout();
        session()->invalidate();
        // Redirect to the users page
        return redirect('account/login')->with('success', 'You have successfully logged out!');
    }

    public function testEmailTemplate()
    {
        return new resetpassMail('token1234');
    }

}
