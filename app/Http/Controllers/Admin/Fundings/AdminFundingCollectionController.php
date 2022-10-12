<?php

namespace App\Http\Controllers\Admin\Fundings;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

/**
 * Class AdminFundingCollectionController
 */
class AdminFundingCollectionController extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->middleware( 'permission:manage_funding_collections' );
    }

    public function getIndex() {
        # Show Grid of All users
    }

    public function getCreateFundingCollection() {
        // Show the page
    }

    public function postCreateFundingCollection(Request $request) {

    }


    public function getEditFundingCollection() {

    }

    public function postEditFundingCollection() {

    }
}
