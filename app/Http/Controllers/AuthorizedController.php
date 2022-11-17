<?php

namespace App\Http\Controllers;


class AuthorizedController extends Controller {


    public function __construct() {
        // Apply the auth filter
        $this->middleware( 'auth' );

    }

}
