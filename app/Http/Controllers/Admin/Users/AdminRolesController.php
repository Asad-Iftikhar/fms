<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\AdminController;
use App\Models\Users\Roles\Role;
use Illuminate\Http\Request;
use DB;

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

    public function createRoles() {
        return view('admin.users.roles.createRoles');
    }

}
