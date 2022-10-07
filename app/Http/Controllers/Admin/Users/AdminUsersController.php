<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Users\User;
use App\Models\Users\Roles\Role;
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
    public function createUser() {
        # Show Grid of All users
        // Show the page
        $user = Auth::user();
        $roles = Role::all();

        return view('admin.users.create', compact('user','roles'))->render();
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
            'employee_id' => 'required|unique:users',
            'username' => 'required|unique:users',
            'email' => 'email|required|unique:users',
            'dob' => 'nullable|date',
            'phone' => 'nullable|min:11|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'

        );
        $validator = Validator::make( request()->all(), $rules );
        if ( $validator->passes() ) {
            $user = new User;
            if(!empty(request()->file('image'))){
                $avatar_id = $this->upload_file(request()->file('image'),'/users/avatars/','user_');
                $user->avatar = $avatar_id;
            }
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->username = $request->input('username');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->dob = $request->input('dob');
            $user->gender = $request->input('gender');
            $user->password = bcrypt($request->input('password'));
            $user->save();
            if($user->id){
                $user->roles()->sync( request()->input( 'roles', array() ) );
                return redirect( 'admin/users/edit' )->with( 'success', 'Updated successfully !' );
            }else{
                return redirect( 'admin/users/edit' )->with( 'error', 'Something Went Wrong !' );
            }
        }
        // Return with errors
        return redirect( 'admin/users/add' )->withInput()->withErrors( $validator );
    }

    /**
     * @return string
     * @param integer $length
     * @throws \Throwable
     */
    function generatePasswordString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
