<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Events\Event;
use App\Models\Fundings\FundingCollection;
use Hashids\Hashids;
use Helpers\DashboardStats;
use App\Models\Users\User;
use App\Models\Activity;

class AdminDashboardController extends AdminController {

    /**
     * Show the administration dashboard page.
     * Stats
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function getIndex() {
        $activeUsersCount = User::where('activated','=',1)->count();
        $activeEvents = Event::where('status','=','active')->get();
        $totalFunds = FundingCollection::totalAvailableFunds();
        $totalPendings = FundingCollection::getOverallPendings();
        $totalCollection = FundingCollection::getTotalCollection();
        //Total Members
        $UsersWithRoles = User::has('Roles')->get()->pluck('id');
        if ( is_array( $UsersWithRoles ) && !empty( $UsersWithRoles ) ) {
            $TotalUsers = User::where( 'activated', '=', true )->whereIntegerNotInRaw( 'id', $UsersWithRoles )->where( 'disabled', '=', false )->count();
        } else {
            $TotalUsers = User::where( 'activated', '=', true )->where( 'disabled', '=', false )->count();
        }
        // Show the page
        return view( 'admin/dashboard/index', compact( 'TotalUsers', 'UsersWithRoles','totalFunds','totalPendings','totalCollection','activeUsersCount','activeEvents'));
    }
}
