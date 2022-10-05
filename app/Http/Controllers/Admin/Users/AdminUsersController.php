<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Users\User;
use DB;

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

    public function fetch_user(Request $request) {
        //dd('hello');
        //print_r($request->all());
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $orderArray = $request->get('order');
        $columnArray = $request->get('columns');

//        $searchArray = $request->get('search');
//        $columnIndex = $orderArray[0]['column'];
//
//        $columnName = $columnArray[$columnIndex]['data'];
//
//        $columnSortOrder = $orderArray[0]['dir'];
//        $searchValue = $searchArray['value'];
//
        $user = User::all();
        $total = $user->count();
        $totalFilter = User::all();
//        if(!empty($searchValue)){
//            $totalFilter = $totalFilter->where('username','like','%'.$searchValue.'%');
//            $totalFilter = $totalFilter->orwhere('email','like','%'.$searchValue.'%');
//        }
//        $totalFilter = $user->count();
//
        $arrData = User::all();
//        $arrData = $arrData->skip($start)->take($rowperpage);
//        $arrData = $arrData->orderBy($columnName,$columnSortOrder);
//
//        if(!empty($searchValue)){
//            $arrData = $arrData->where('username','like','%'.$searchValue.'%');
//            $arrData = $arrData->orwhere('email','like','%'.$searchValue.'%');
//        }
//        $arrData = $arrData->get();
        $data_arr = array();
        foreach($user as $data){
            $id = $data->id;
            $username = $data->username;
            $email = $data->email;

            $data_arr[] = array(
                "id" => $id,
                "username" => $username,
                "email" => $email
            );
        }
        $response = array(
          "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $totalFilter,
            "data" => $data_arr,
        );

        return response()->json($response);
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
