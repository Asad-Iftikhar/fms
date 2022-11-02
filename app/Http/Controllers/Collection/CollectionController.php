<?php

namespace App\Http\Controllers\Collection;


use App\Http\Controllers\AuthController;
use App\Models\Fundings\FundingCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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
            return view("site.collection.received", compact('previousPayments'));
        }
    }

    /**
     * Previous Collection with respect to id
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getCollection($id)
    {
        $user = Auth::user();
        $rules = [
            'id' => $id
        ];

        $validator = Validator::make($rules, [
            'id' => 'required|exists:funding_collections,id'
        ]);
        if ($validator->passes()) {
            $previousPayments = FundingCollection::find($id);
            if ($previousPayments->user_id == $user->id) {
                    return view('site.collection.detail', compact('previousPayments'));
            } else {
                return redirect('account/collection')->with('error', "Insufficient permission");
            }
        } else {
            return redirect('account/collection')->with('error', "No Record Exist");
        }
    }
}
