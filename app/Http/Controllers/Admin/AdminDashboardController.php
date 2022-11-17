<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Events\Event;
use App\Models\Fundings\FundingCollection;
use Hashids\Hashids;
use Helpers\DashboardStats;
use App\Models\Users\User;
use App\Models\Activity;
use Illuminate\Support\Carbon;

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
        $pendingCollectionPercentage = FundingCollection::getPendingCollectionPercentage();
        $receivedCollectionPercentage = FundingCollection::getReceivedCollectionPercentage();

        //Total Members
        $UsersWithRoles = User::has('Roles')->get()->pluck('id');
        if ( is_array( $UsersWithRoles ) && !empty( $UsersWithRoles ) ) {
            $TotalUsers = User::where( 'activated', '=', true )->whereIntegerNotInRaw( 'id', $UsersWithRoles )->where( 'disabled', '=', false )->count();
        } else {
            $TotalUsers = User::where( 'activated', '=', true )->where( 'disabled', '=', false )->count();
        }
        // Show the page
        return view( 'admin/dashboard/index', compact( 'TotalUsers', 'UsersWithRoles','totalFunds','totalPendings','totalCollection','activeUsersCount','activeEvents', 'pendingCollectionPercentage','receivedCollectionPercentage'));
    }

    function getAllMonths(){
        $monthArray = array();
        $collectionDates = FundingCollection::orderBy('created_at','ASC')->pluck('created_at');
        $collectionDates = json_decode($collectionDates);
        if( !empty($collectionDates) ) {
            foreach ( $collectionDates as $unformattedDates ) {
                $date = new \DateTime( $unformattedDates );
                $monthNo = $date->format( 'm' );
                $monthName = $date->format( 'M' );
                $monthArray[$monthNo] = $monthName;
            }
        }
        return $monthArray;
    }

    function getMonthlyCollectionCount( $month ){
            $monthlyCollectionCount = FundingCollection::whereMonth('created_at',$month)->get()->count();
            return $monthlyCollectionCount;
    }

    function getMonthlyCollectionData(){

        $monthlyCollectionCountArray = array();
        $monthArray = $this->getAllMonths();
        $monthNameArray = array();
        if(!empty($monthArray)) {
            foreach ($monthArray as $monthNo => $monthName ) {
                $monthlyCollectionCount = $this->getMonthlyCollectionCount($monthNo);
                array_push($monthlyCollectionCountArray, $monthlyCollectionCount);
                array_push($monthNameArray, $monthName);
            }
        }
        $maxNo = max( $monthlyCollectionCountArray );
        $max = round($maxNo);
        $monthlyCollectionDataArray = array(
            'month' => $monthNameArray,
            'collectionCount' => $monthlyCollectionCountArray,
            'max' => $max,
        );

        return $monthlyCollectionDataArray;
    }
}
