<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\AuthController;
use App\Models\Fundings\FundingCollection;
use Illuminate\Support\Facades\Auth;

class CollectionController extends AuthController
{
    /**
     * Get Home Page View
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        if (!Auth::check()) {
            return view('site.account.login');
        } else {
            $User = Auth::user();
            $previousPayments = FundingCollection::where('user_id', $User->id)->where('is_received', '=', 1)->get();
            return view("user.collection", compact('previousPayments'));
        }
    }

    /**
     * Previous Collection with respect to id
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getCollectionId($id)
    {
        $previousPayments = FundingCollection::find($id);
        return view('user.collection_view', compact('previousPayments'));
    }
}
