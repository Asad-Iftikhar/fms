<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Users\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class AdminUsersController
 */
class AdminUsersController extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->middleware( 'permission:manage_users' );
    }

    /**
     * Show a list of users.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getIndex() {
        # Show Grid of All users
        // Show the page
        $data = User::all();
        return view('admin.users.index', compact('data'))->render();
    }

    /**
     * Show add user form.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function addUser() {
        # Show Grid of All users
        // Show the page
        $user = Auth::user();
        return view('admin.users.create', compact('user'))->render();
    }


    /**
     * Users create form post
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postUser(Request $request) {
        $user = Auth::user();
        //  Validate Form
        $rules = array (
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'employee_id' => 'required|integer|unique:users',
            'username' => 'required|unique:users',
            'email' => 'email|required|unique:users',
            'dob' => 'nullable|date',
            'phone' => 'nullable|min:11|unique:users',
            'password' => 'required|min:8',
            'image' => 'mimes:jpeg,png,jpg,svg|required|max:3072'

        );
        $validator = Validator::make( request()->all(), $rules );
        if ( $validator->passes() ) {
            $user = new User;
            $avatar_id = $this->upload_file(request()->file('image'),'/users/avatars/','user_');

            $user->first_name = $request->input('first_name');
            $user->avatar = $avatar_id;
            $user->last_name = $request->input('last_name');
            $user->username = $request->input('username');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->dob = $request->input('dob');
            $user->gender = $request->input('gender');
            $user->password = bcrypt($request->input('gender'));
            $user->save();
            return redirect( 'account/setting/profile' )->with( 'success', 'Updated successfully !' );
        }
        // Return with errors
        return redirect( 'account/setting/profile' )->withInput()->withErrors( $validator );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function fetch_user(Request $request) {
        # Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $orderArray = $request->get('order');
        $columnNameArray = $request->get('columns'); //it will give us columns array.

        $searchArray = $request->get('search');
        $columnIndex = $orderArray[0]['column']; //which column index should be sorted.

        $columnName = $columnNameArray[$columnIndex]['data']; //here we will get the column name based on the index we get.

        $columnSortOrder = $orderArray[0]['dir']; //this will get us order direction
        $searchValue = $searchArray['value']; //This is search value

        $user = DB::table('users');
        $total = $user->count();

        $totalFilter = DB::table('users');
        if (!empty($searchValue)){
            $totalFilter = $totalFilter->where('username', 'like', '%'.$searchValue.'%');
            $totalFilter = $totalFilter->orwhere('email', 'like', '%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = DB::table('users');
        $arrData = $arrData->skip($start)->take($rowperpage);

        //sorting
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        //searching
        if (!empty($searchValue)){
            $arrData = $arrData->where('username', 'like', '%'.$searchValue.'%');
            $arrData = $arrData->orwhere('email', 'like', '%'.$searchValue.'%');
        }

        $arrData = $arrData->get();

        $response = array(
          "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }

    # Create User
    # Update User profiles
    # Everything related to User Management

}
