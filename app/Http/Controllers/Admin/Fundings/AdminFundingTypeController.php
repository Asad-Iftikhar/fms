<?php

namespace App\Http\Controllers\Admin\Fundings;

use App\Http\Controllers\AdminController;
use App\Models\Fundings\FundingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminFundingTypeController extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->middleware('permission:manage_funding_type');
    }

    /**
     * Show a list of fund types.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getIndex() {
        $fundingTypes = FundingType::all();
        return view('admin.fundings.index',['fundingtypes'=>$fundingTypes]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getCreateFundingType() {
        $fundingTypes = FundingType::all();
        return view('admin.fundings.create',compact('fundingTypes'));
    }

    /**
     * Create Fund Type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function  postCreateFundingType() {

        $rules = array(
            'name' => 'required|unique:fundingtype,name,',
            'description' => 'max:255',
            'amount' => 'required|numeric',
        );

        $validator = Validator::make(request()->only(['name','description','amount']), $rules);
        if ( $validator->fails() ) {
            return redirect('admin/funding/types/create')->withInput()->withErrors($validator);
        } else {
            try {
                $fundingType = new FundingType();
                $fundingType->name = request()->input('name');
                $fundingType->description = request()->input('description');
                $fundingType->amount = request()->input('amount');
                if( $fundingType->save() ){
                    return redirect('admin/funding/types/edit/'. $fundingType->id)->with('success', "Created successfully");
                }
            } catch ( Exception $e ) {
                return redirect('admin/funding/types/create')->with('error', "operation failed");
            }
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getEditFundType($id) {
        if( $fundTypeId = FundingType::find($id) ) {
            return view('admin.fundings.edit',compact('fundTypeId'));
        }
    }

    /**
     * Update Fund Type
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditFundType($id) {
        if( $fundTypeId = FundingType::find($id) ) {
            $rules = array(
                'name' => 'required|unique:fundingtype,name' . $fundTypeId,
                'description' => 'max:255',
                'amount' => 'required|numeric',
            );

            $validator = Validator::make(request()->only(['name', 'description', 'amount']), $rules);
            if ( $validator->fails() ) {
                return redirect('admin/funding/types/edit/'.$id)->withInput()->withErrors($validator);
            } else {
                try {
                    $fundTypeId->name = request()->input('name');
                    $fundTypeId->description = request()->input('description');
                    $fundTypeId->amount = request()->input('amount');
                    if ( $fundTypeId->save() ) {
                        return redirect()->back()->with('success', 'Updated Successfully');
                    }
                } catch ( Exception $e ) {
                    return redirect()->back()->with('error', "Something went wrong");
                }
            }
        }
        return redirect()->with('error', "Funding type does not exist");
    }
}
