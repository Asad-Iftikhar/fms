<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Hashids\Hashids;
use Illuminate\Support\Carbon;
use Helpers\DashboardStats;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Users\User;
use App\Models\Activity;

class AdminDashboardController extends AdminController {

    /**
     * Show the administration dashboard page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function getIndex() {
        //Total Members
        $UsersWithRoles = DB::table( 'role_user' )->pluck( 'user_id' )->all();
        if ( is_array( $UsersWithRoles ) && !empty( $UsersWithRoles ) ) {
            $TotalUsers = User::where( 'activated', '=', true )->whereIntegerNotInRaw( 'id', $UsersWithRoles )->where( 'disabled', '=', false )->count();
        } else {
            $TotalUsers = User::where( 'activated', '=', true )->where( 'disabled', '=', false )->count();
        }
        // Show the page
        return view( 'admin/dashboard/index', compact( 'TotalUsers', 'UsersWithRoles') );
    }
}
