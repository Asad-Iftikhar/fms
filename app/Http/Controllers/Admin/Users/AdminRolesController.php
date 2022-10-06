<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\AdminController;
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
    public function getIndex(){
        # Show Grid of All users roles
        // Show the page
        $data = DB::table('roles');
        return view('admin.users.roles.index', compact('data'))->render();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function fetch_userRoles(Request $request) {
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

        $roles = DB::table('roles');
        $total = $roles->count();

        $totalFilter = DB::table('roles');
        if (!empty($searchValue)){
            $totalFilter = $totalFilter->where('id', 'like', '%'.$searchValue.'%');
            $totalFilter = $totalFilter->orwhere('name', 'like', '%'.$searchValue.'%');
        }
        $totalFilter = $totalFilter->count();

        $arrData = DB::table('roles');
        $arrData = $arrData->skip($start)->take($rowperpage);

        //sorting
        $arrData = $arrData->orderBy($columnName, $columnSortOrder);

        //searching
        if (!empty($searchValue)){
            $arrData = $arrData->where('id', 'like', '%'.$searchValue.'%');
            $arrData = $arrData->orwhere('name', 'like', '%'.$searchValue.'%');
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
}
