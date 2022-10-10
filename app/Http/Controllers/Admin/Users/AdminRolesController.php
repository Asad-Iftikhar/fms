<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\AdminController;
use App\Models\Users\Roles\Role;
use App\Models\Users\User;
use App\Models\Users\Roles\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminRolesController extends AdminController {
    //
    public function __construct() {
        parent::__construct();
        $this->middleware('permission:manage_roles');
    }

    /**
     * Show a list of users roles.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getIndex() {
        # Show Grid of All users roles
        $roles = Role::withCount(['permissions'])->get();
        return view('admin.users.roles.index', ['roles'=>$roles]);
    }


    /**
     * @return string
     */
    public function getCreateRole() {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.users.roles.create',compact('roles','permissions'));
    }

    /**
     * Create User Roles
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postCreateRole(Request $request)
    {
        $rules = array(
            'name' => 'required|alpha_dash|unique:roles,name',
            'description' => 'max:255',
            'level' => 'required|numeric',
        );

        $validator = Validator::make($request->all(), $rules);
        if ( $validator->fails() ) {
            return redirect('admin/roles/create')->withInput()->withErrors($validator);
        } else {
            $data = $request->input();
            try {
                $roles = new Role();
                $roles->name = $data['name'];
                $roles->description = $data['description'];
                $roles->level = $data['level'];

                if( $roles->save() ){
                    $roles->permissions()->sync(request()->input('permissions',array()));
                    return redirect('admin/roles/edit/'. $roles->id)->with('success', "Created successfully");
                }
            } catch (Exception $e) {
                return redirect('admin/roles/create')->with('error', "operation failed");
            }
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getEditRole($id) {
        if( $role = Role::find($id) ) {
            $roles = Role::all();
            $permissions = Permission::all();
            $selected_permissions = $role->permissions->pluck('id')->toArray();
            return view('admin.users.roles.edit',compact('roles','role','permissions', 'selected_permissions'));
        }
    }

    /**
     * Update User Role
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditRole($id) {
        if( $role = Role::find($id) ) {
            $rules = array(
                'name' => 'required|alpha_dash|unique:roles,name,' . $role->id,
                'description' => 'max:255',
                'level' => 'required|numeric',
            );

            $validator = Validator::make(request()->only(['name', 'description', 'level']), $rules);
            if ( $validator->fails() ) {
                return redirect('admin/roles/edit')->withInput()->withErrors($validator);
            } else {
                try {
                    $role->name = request()->input('name');
                    $role->description = request()->input('description');
                    $role->level = request()->input('level');
                    if ( $role->save() ) {
                        $role->permissions()->sync(request()->input('permissions', array()));
                        return redirect()->back()->with('success', 'Updated Successfully');
                    }
                } catch (Exception $e) {
                    return redirect()->back()->with('error', "Something went wrong");
                }
            }
        }
        return redirect()->with('error', "Role not exists");
    }

}
