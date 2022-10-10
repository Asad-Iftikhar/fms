<?php

namespace App\Http\Controllers\Admin\Fundings;

use App\Http\Controllers\AdminController;
use App\Models\Fundings\FundingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminFundingTypeController extends AdminController {

    public function __construct() {
//        parent::__construct();
//        $this->middleware('permission:manage_funding'); //manage funding type
    }

    public function getIndex(){
        $fundingtypes = FundingType::all();
        return view('admin.fundings.index',['fundingtypes'=>$fundingtypes]);
    }

    public function getCreateFundingType(){
        $fundingtypes = FundingType::all();
        return view('admin.fundings.create',compact('fundingtypes'));
    }

    public function  postCreateFundingType(){

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
                $fundingtype = new FundingType();
                $fundingtype->name = request()->input('name');
                $fundingtype->description = request()->input('description');
                $fundingtype->amount = request()->input('amount');
                if( $fundingtype->save() ){
                    return redirect('admin/funding/types/edit/'. $fundingtype->id)->with('success', "Created successfully");
                }
            } catch ( Exception $e ) {
                return redirect('admin/funding/types/create')->with('error', "operation failed");
            }
        }
    }

    public function getEditFundType($id){
        if( $fundtypeid = FundingType::find($id) ) {
            return view('admin.fundings.edit',compact('fundtypeid'));
        }
    }

    public function postEditFundType($id){
        if( $fundtypeid = FundingType::find($id) ) {
            $rules = array(
                'name' => 'required|unique:fundingtype,name',
                'description' => 'max:255',
                'amount' => 'required|numeric',
            );

            $validator = Validator::make(request()->only(['name', 'description', 'amount']), $rules);
            if ( $validator->fails() ) {
                return redirect('admin/funding/types/edit/'.$id)->withInput()->withErrors($validator);
            } else {
                try {
                    $fundtypeid->name = request()->input('name');
                    $fundtypeid->description = request()->input('description');
                    $fundtypeid->amount = request()->input('amount');
                    if ( $fundtypeid->save() ) {
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
