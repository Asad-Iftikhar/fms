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

    /**
     * Get all records on the basis of created_at column
     *
     * @return array
     * @throws \Exception
     */
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

    /**
     * Sum of amount with respect to each month
     *
     * @param $month
     * @return mixed
     */
    function getMonthlyCollectionCount($month ){
            $monthlyCollectionCount = FundingCollection::whereMonth('created_at',$month)->get()->sum('amount');
            return $monthlyCollectionCount;
    }

    /**
     * json response
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
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

        return response()->json($monthlyCollectionDataArray);
    }

    /**
     * Percentages of pending and received collections
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function getCollectionPercentage(){

        $pendingCollectionPercentage = FundingCollection::where('is_received',0)->count();
        $totalCollectionCount = FundingCollection::count();
        $pendingPercentage = round(($pendingCollectionPercentage / $totalCollectionCount)*100);

        $receivedCollectionPercentage = FundingCollection::where('is_received',1)->count();
        $totalCollectionCount = FundingCollection::count();
        $receivedPercentage = round(($receivedCollectionPercentage / $totalCollectionCount)*100);

        $collectionArray = array(
            'pendings'=> $pendingPercentage,
            'received'=> $receivedPercentage
        );

        return response()->json($collectionArray);
    }
}
