<?php

namespace App\Http\Controllers\Admin\Fundings;

use App\Http\Controllers\AdminController;
use App\Models\Fundings\FundingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminFundingTypeController extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->middleware('permission:manage_funding_types');
    }

    /**
     * Show a list of fund types.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getIndex() {
        $fundingTypes = FundingType::all();
        return view('admin.fundings.types.index',compact('fundingTypes'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getCreateFundingType() {
        $fundingTypes = FundingType::all();
        return view('admin.fundings.types.create',compact('fundingTypes'));
    }

    /**
     * Create Fund Type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function  postCreateFundingType() {
        $rules = array(
            'name' => 'required|unique:funding_types,name,',
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
    public function getEditFundingType($id) {
        if( $fundingType = FundingType::find($id) ) {
            return view('admin.fundings.types.edit',compact('fundingType'));
        }
    }

    /**
     * Update Fund Type
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postEditFundingType($id) {
        if( $fundingType = FundingType::find($id) ) {
            $rules = array(
                'name' => 'required|unique:funding_types,name,' . $id,
                'description' => 'max:255',
                'amount' => 'required|numeric',
            );

            $validator = Validator::make(request()->only(['name', 'description', 'amount']), $rules);
            if ( $validator->fails() ) {
                return redirect('admin/funding/types/edit/'.$id)->withInput()->withErrors($validator);
            } else {
                try {
                    $fundingType->name = request()->input('name');
                    $fundingType->description = request()->input('description');
                    $fundingType->amount = request()->input('amount');
                    if ( $fundingType->save() ) {
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
