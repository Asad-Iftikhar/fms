<?php namespace App\Http\Controllers\Account;

use App\Http\Controllers\AuthorizedController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AccountController extends AuthorizedController {

    /**
     * Shows the account main page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function getIndex() {
        // Get the user information
        $user = Auth::user();
        return view( 'site/account/dashboard', compact( 'user' ) );
    }

    /**
     * Users settings page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\View
     */
    public function getProfileSettings() {
        // Get the user information
        $user = Auth::user();

        // Show the page
        return view( 'site/account/setting/index', compact( 'user' ) );
    }

    /**
     * Users settings page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postProfileSettings(Request $request) {
        // Get the user information
        $user = Auth::user();

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->username = $request->input('username');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->dob = $request->input('dob');
        $user->gender = $request->input('gender');
        $user->save();
        // Show the page
        return redirect( 'account/profile-settings' )->with( 'success', 'Updated successfully !' );
    }

    /**
     * Users settings form processing page.
     *
     * @return \Illuminate\Http\RedirectResponse|\Redirect
     */
    public function postSettings() {
        # Update Settings, email, password, username, fname etc

    }

    /**
     * Verify if Email is Taken
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxVerifyEmail() {
        $rules = array('email' => 'unique:users,email,' . Auth::user()->email . ',email');

        $validator = Validator::make( request()->only( ['email'] ), $rules );
        if ( $validator->passes() ) {
            return response()->json( true );
        } else {
            return response()->json( request()->input( 'email' ) . ' is already in use.' );
        }
    }

    /**
     * Verify if Username is Taken
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxVerifyUserName() {
        $rules = array('username' => 'unique:users,username,' . Auth::user()->username . ',username');

        $validator = Validator::make( request()->only( ['username'] ), $rules );
        if ( $validator->passes() ) {
            return response()->json( true );
        } else {
            return response()->json( request()->input( 'username' ) . ' is already in use.' );
        }
    }

}
