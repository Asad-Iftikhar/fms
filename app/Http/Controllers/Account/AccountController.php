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
     * Users settings form processing page.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postProfileSettings(Request $request) {
        $user = Auth::user();
        //  Validate Form
        $rules = array (
            'first_name' => 'string|required',
            'last_name' => 'string',
            'username' => 'required|unique:users,username,'.$user->id,
            'email' => 'email|required|unique:users,email,'.$user->id,
            'dob' => 'required|date',
            'phone' => 'nullable|min:11|unique:users,phone,'.$user->id
        );
        $validator = Validator::make( request()->all(), $rules );
        if ( $validator->passes() ) {
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->username = $request->input('username');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->dob = $request->input('dob');
            $user->gender = $request->input('gender');
            $user->save();
            return redirect( 'account/setting/profile' )->with( 'success', 'Updated successfully !' );
        }
        // Return with errors
        return redirect( 'account/setting/profile' )->withInput()->withErrors( $validator );
    }

    /**
     * Change Password form processing page.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postChangePassword(Request $request) {
        $user = Auth::user();
        //  Validate Form
        $rules = array (
            'current_password' => 'current_password',
            'new_password' => 'required|min:6|different:password',
            'confirm_password' => 'required|same:new_password'
        );
        $validator = Validator::make( request()->all(), $rules );
        if ( $validator->passes() ) {
            $user->password = bcrypt($request->input('new_password'));
            $user->save();
            return redirect( 'account/setting/change-password' )->with( 'success', 'Password Updated Successfully !' );
        }
        // Return with errors
        return redirect( 'account/setting/change-password' )->withInput()->withErrors( $validator );
    }

    /**
     * User Avatar processing page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postChangeAvatar() {
        $user = Auth::user();
        //  Validate Form
        $rules = array (
            'image' => 'mimes:jpeg,png,jpg,svg|required|max:3072',
        );
        $validator = Validator::make( request()->all(), $rules );
        if ( $validator->passes() ) {
            $avatar_id = $this->upload_file(request()->file('image'),'/users/avatars/','user_');
            if ( $avatar_id ) {
                $this->remove_file($user->avatar);
                $user->avatar = $avatar_id;
                $user->save();
                return redirect( 'account/setting/avatar' )->with( 'success', 'Image Updated Successfully !' );
            } else {
                return redirect( 'account/setting/avatar' )->with( 'error', 'Something Went Wrong !' );
            }
        }
        // Return with errors
        return redirect( 'account/setting/avatar' )->withInput()->withErrors( $validator );
    }

    /**
     * User Avatar processing page.
     * @return
     */
    public function removeAvatar() {
        $user = Auth::user();
        if($user->avatar){
            $this->remove_file($user->avatar);
            $user->avatar = null;
            $user->save();
            return redirect( 'account/setting/avatar' )->with( 'success', 'Successfully Removed !' );
        }
        return redirect( 'account/setting/avatar' )->with( 'error', 'Image Already Removed !' );
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
