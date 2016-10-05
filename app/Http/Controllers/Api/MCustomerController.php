<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MCUSTOMER;
use App\MPrefix;
use Datatables;
use DB;

class MCustomerController extends Controller
{
	public function index(){
		 $this->iteration = 0;
        $mcustomer = MCUSTOMER::where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($mcustomer)->addColumn('action', function($mcustomer){
          
          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewmcustomer('.$mcustomer->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editmcustomer('.$mcustomer->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mcustomer->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($mcustomer){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })
        ->make(true);
}

  public function show($id){
    $mcustomer = MCUSTOMER::find($id);
    return response()->json($mcustomer);
  }

  public function update(Request $request,$id){
      $new_cust = MCUSTOMER::find($id);
      $new_cust->mcustomerid = $request->mcustomerid;
      $new_cust->mcustomername = $request->mcustomername;
      $new_cust->mcustomeremail = $request->mcustomeremail;
      $new_cust->mcustomerphone = $request->mcustomerphone;
      $new_cust->mcustomerfax = $request->mcustomerfax;
      $new_cust->mcustomerwebsite = $request->mcustomerwebsite;
      $new_cust->mcustomeraddress = $request->mcustomeraddress;
      $new_cust->mcustomercity = $request->mcustomercity;
      $new_cust->mcustomerzipcode = $request->mcustomerzipcode;
      $new_cust->mcustomerprovince = $request->mcustomerprovince;
      $new_cust->mcustomercountry = $request->mcustomercountry;
      $new_cust->mcustomercontactname = $request->mcustomercontactname;
      $new_cust->mcustomercontactposition = $request->mcustomercontactposition;
      $new_cust->mcustomercontactemail = $request->mcustomercontactemail;
      $new_cust->mcustomercontactemailphone = $request->mcustomercontactemailphone;
      $new_cust->mcustomercontactname = $request->mcustomercontactname;
      $new_cust->mcustomercontactposition = $request->mcustomercontactposition;
      $new_cust->mcustomercontactemail = $request->mcustomercontactemail;
      $new_cust->mcustomercontactemailphone = $request->mcustomercontactemailphone;
      $new_cust->save();
    return response()->json($new_cust);
  }

	public function store(Request $request){
		if ($request->autogen == 'true') {
      $prefix = MPrefix::where('mprefixtransaction','Master Customer')->first();
      $new_cust = new MCUSTOMER;
      $prefix->last_count++;
      $new_cust->mcustomerid = $prefix->mprefix.'-'.$prefix->last_count;
      $new_cust->mcustomername = $request->mcustomername;
      $new_cust->mcustomeremail = $request->mcustomeremail;
      $new_cust->mcustomerphone = $request->mcustomerphone;
      $new_cust->mcustomerfax = $request->mcustomerfax;
      $new_cust->mcustomerwebsite = $request->mcustomerwebsite;
      $new_cust->mcustomeraddress = $request->mcustomeraddress;
      $new_cust->mcustomercity = $request->mcustomercity;
      $new_cust->mcustomerzipcode = $request->mcustomerzipcode;
      $new_cust->mcustomerprovince = $request->mcustomerprovince;
      $new_cust->mcustomercountry = $request->mcustomercountry;
      $new_cust->mcustomercontactname = $request->mcustomercontactname;
      $new_cust->mcustomercontactposition = $request->mcustomercontactposition;
      $new_cust->mcustomercontactemail = $request->mcustomercontactemail;
      $new_cust->mcustomercontactemailphone = $request->mcustomercontactemailphone;
      $new_cust->mcustomercontactname = $request->mcustomercontactname;
      $new_cust->mcustomercontactposition = $request->mcustomercontactposition;
      $new_cust->mcustomercontactemail = $request->mcustomercontactemail;
      $new_cust->mcustomercontactemailphone = $request->mcustomercontactemailphone;
      $new_cust->void = 0;
      $new_cust->save();
      $prefix->save();
      return response()->json($new_cust);
    }

    else{
    $new_cust = MCUSTOMER::create($request->all());
		$new_cust->void = 0;
		$new_cust->save();
		return response()->json($new_cust);
    }


	}


   public function destroy($id){
    $mbranch = MCUSTOMER::find($id);
    DB::table('mcustomer')->where('id',$id)->update(['void' => '1']);
    return response()->json();
    }

}