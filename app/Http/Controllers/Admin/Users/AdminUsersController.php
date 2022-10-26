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
        return view('admin.users.index')->render();
    }

    /**
     * Show add user form.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getCreateUser() {
        // Show the page
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }


    /**
     * Users create form post
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreateUser(Request $request) {

        //  Validate Form
        $rules = array (
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'employee_id' => 'nullable|unique:users',
            'username' => 'required|unique:users',
            'email' => 'email|required|unique:users',
            'dob' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'phone' => 'nullable|min:11|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'

        );
        $validator = Validator::make( request()->all(), $rules );
        if ( $validator->passes() ) {
            $user = new User;
            /*if(!empty(request()->file('image'))){
                $avatar_id = $this->upload_file(request()->file('image'),'/users/avatars/','user_');
                $user->avatar = $avatar_id;
            }*/
            $user->employee_id = $request->input('employee_id');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->username = $request->input('username');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->dob = $request->input('dob');
            $user->joining_date = $request->input('joining_date');
            $user->gender = $request->input('gender');
            $user->password = bcrypt($request->input('password'));
            if($user->save()){
                $user->roles()->sync( request()->input( 'roles', array() ) );
                return redirect( 'admin/users/edit/'.$user->id )->with( 'success', 'Created Successfully !' );
            }else{
                return redirect( 'admin/users/edit/'.$user->id )->with( 'error', 'Something Went Wrong !' );
            }
        }
        // Return with errors
        return redirect( 'admin/users/create' )->withInput()->withErrors( $validator );
    }

    /**
     * Show add user form.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getEditUser($user_id) {
        // Show the page
        if( $user_id == 1 ){
            return redirect( 'admin/users' )->with( 'error', 'Not allowed' );
        }
        $roles = Role::all();
        $user = User::find($user_id);
        if($user = User::find($user_id)){
            $selected_roles = $user->roles()->pluck('id')->toArray();
            return view('admin.users.edit', compact('user','roles','selected_roles'));
        }
        return redirect('admin/users')->with( 'error', 'User Not Found' );
    }


    /**
     * Users create form post
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditUser($user_id) {
        if( $user = User::find($user_id) ){
            if( $user->id == 1 ) {
                return redirect( 'admin/users' )->with( 'error', 'Not allowed' );
            }
            $request = request();
            //  Validate Form
            $rules = array (
                'first_name' => 'nullable|string',
                'last_name' => 'nullable|string',
                'employee_id' => 'nullable|unique:users,employee_id,'.$user->id,
                'username' => 'required|unique:users,username,'.$user->id,
                'email' => 'email|required|unique:users,email,'.$user->id,
                'dob' => 'nullable|date',
                'joining_date' => 'nullable|date',
                'phone' => 'nullable|min:11|unique:users,phone,'.$user->id,
                'password' => 'nullable|required_with:password_confirmation|min:6|confirmed',

            );
            $validator = Validator::make( request()->all(), $rules );
            if ( $validator->passes() ) {
                /*if(!empty(request()->file('image'))){
                    $avatar_id = $this->upload_file(request()->file('image'),'/users/avatars/','user_');
                    $user->avatar = $avatar_id;
                }*/
                $user->employee_id = $request->input('employee_id');
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->username = $request->input('username');
                $user->phone = $request->input('phone');
                $user->email = $request->input('email');
                $user->dob = $request->input('dob');
                $user->joining_date = $request->input('joining_date');
                $user->gender = $request->input('gender');
                if ( $request->input('password') != '' ) {
                    $user->password = bcrypt($request->input('password'));
                }
                if ($user->save()) {
                    $user->roles()->sync( request()->input( 'roles', array() ) );
                    return redirect( 'admin/users/edit/'.$user->id )->with( 'success', 'Updated Successfully !' );
                } else {
                    return redirect( 'admin/users/edit/'.$user->id )->with( 'error', 'Something Went Wrong !' );
                }
            }
            // Return with errors
            return redirect( 'admin/users/edit/'.$user->id )->withInput()->withErrors( $validator );
        }
        return redirect('admin/users');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function fetchUsers(Request $request) {
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

        $total = User::count();

        $totalFilter = User::query()->where('deleted_at', NULL);
        if (!empty($searchValue)){
            $totalFilter = $totalFilter->where('username', 'like', '%'.$searchValue.'%');
            $totalFilter = $totalFilter->orwhere('email', 'like', '%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = User::query()->where('deleted_at', NULL);
        $arrData = $arrData->skip($start)->take($rowperpage);

        //sorting
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        //searching
        if (!empty($searchValue)){
            $arrData = $arrData->where('username', 'like', '%'.$searchValue.'%');
            $arrData = $arrData->orwhere('email', 'like', '%'.$searchValue.'%');
        }

        $arrData = $arrData->get();
        foreach ($arrData as $data){
            $data->activeStatus = $data->getUserActiveStatus();
            if($data->id != 1){
                $data->action= $data->getChangeStatusButton().'&nbsp;<a href="'.url('admin/users/edit').'/'. $data->id .'" class="edit btn btn-sm btn-outline-primary"><i class="iconly-boldEdit"></i></a>&nbsp;<button onClick="confirmDelete(\''.url('admin/users/delete').'/'. $data->id.'\')" class="delete-btn delete btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>';
            }else{
                $data->action='<span> --N/A-- </span>';
            }
        }
        $response = array(
          "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $arrData,
        );

        return response()->json($response);
    }

    /**
     * Soft Delete User
     * @param $userId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeStatus($userId) {
        if( $userId == 1 ){
            return redirect( 'admin/users' )->with( 'error', 'Super Admin Status Cannot Be Changed' );
        }else{
            if( $user = User::find($userId) ) {
                if ( $user->activated ) {
                    $user->activated = 0;
                } else {
                    $user->activated = 1;
                }
                if ( $user->save() ) {
                    return redirect()->back()->with('success', "Status Changed Successfully");
                } else {
                    return redirect()->back()->with('error', "Something Went Wrong");
                }
            } else {
                return redirect()->back()->with('error', "User doesn't exists");
            }
        }
    }

    /**
     * Soft Delete User
     * @param $userId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteUser($userId) {
        if( $userId == 1 ){
            return redirect( 'admin/users' )->with( 'error', 'Not allowed' );
        }else{
            if( $role = User::find($userId) ) {
                $role->delete();
                return redirect()->back()->with('success', 'Deleted Successfully');
            } else {
                return redirect()->back()->with('error', "User doesn't exists");
            }
        }
    }
}
