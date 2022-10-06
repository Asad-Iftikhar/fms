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
