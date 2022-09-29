<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\AdminController;
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
        // return view( 'admin/users/index', compact( 'TotalUsers', 'NewUsers', 'ActiveUsers' ) );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function postGetUsers() {
        # DataTable Data Populating
        // return response()->json( array('users' => $UserHtml, 'filters' => $activeFilters, 'query' => $CurrentIDs, 'total' => number_format($Users->Total()), 'pagination' => $Users->links( 'vendor.pagination.default' )->toHtml(), 'pagination_number' => $PaginationNumber), 200 );
    }

    # Create User
    # Update User profiles
    # Everything related to User Management

}
