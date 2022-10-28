<?php

namespace App\Http\Controllers;


use App\Models\Fundings\FundingCollection;
use App\Models\Events\Event;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    /**
     * Get Home Page View
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view("user.collection");
    }
}
