<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MConfig;
use Exception;
use Carbon\Carbon;
use Validator;

class MConfigController extends Controller
{

    private function convertBoolean($string_bool){
      if($string_bool == "true"){
        return 1;
      } else {
        return 0;
      }
    }

    public function index(){
      $mconfig = MConfig::find(1);
      return response()->json($mconfig);
    }

    public function update(Request $request){
      try{
        $mconfig = MConfig::find(1);
        $mconfig->update($request->all());
        if($request->msyscompstartdate != null){
          $mconfig->msyscompstartdate = Carbon::createFromFormat('Y-m-d',$request->msyscompstartdate);
        }
        if($request->msyscomptaxabledate != null){
          $mconfig->msyscomptaxabledate = Carbon::createFromFormat('Y-m-d',$request->msyscomptaxabledate);
        }
        $mconfig->msyscomptaxable = $this->convertBoolean($request->msyscomptaxable);
        $mconfig->msysgenmanufacturingacc = $this->convertBoolean($request->msysgenmanufacturingacc);
        $mconfig->msysgenmultibranch = $this->convertBoolean($request->msysgenmultibranch);
        $mconfig->msysgenmulticurrency = $this->convertBoolean($request->msysgenmulticurrency);
        $mconfig->msysgendefaulttax = $this->convertBoolean($request->msysgendefaulttax);
        $mconfig->msysgenapproval = $this->convertBoolean($request->msysgenapproval);
        $mconfig->msysgenfixedasset = $this->convertBoolean($request->msysgenfixedasset);
        $mconfig->msysgenfixedasset = $this->convertBoolean($request->msysgenfixedasset);
        $mconfig->save();
        return response()->json($mconfig);
      } catch(Exception $e){
        return response()->json($e);
      }
    }

    public function update_feature(Request $request){
      $mconfig = MConfig::find(1);
      $mconfig->msysinvquotation = $this->convertBoolean($request->msysinvquotation);
      $mconfig->msysinvproformainvoice = $this->convertBoolean($request->msysinvproformainvoice);
      $mconfig->msysinvsellinginvoice = $this->convertBoolean($request->msysinvsellinginvoice);
      $mconfig->msysinvlocksellingprice = $this->convertBoolean($request->msysinvlocksellingprice);
      $mconfig->msysinvcreditlimit = $this->convertBoolean($request->msysinvcreditlimit);
      $mconfig->msysinvinvfootnote = $request->msysinvinvfootnote;
      $mconfig->msysinvsellingfootnote = $request->msysinvsellingfootnote;
      $mconfig->msysinvspbelowcog = $this->convertBoolean($request->msysinvspbelowcog);
      $mconfig->msysinvprintinvmorethanonce = $this->convertBoolean($request->msysinvprintinvmorethanonce);
      $mconfig->msysinvprintdomorethanonce = $this->convertBoolean($request->msysinvprintdomorethanonce);
      $mconfig->msysinvprintordmorethanonce = $this->convertBoolean($request->msysinvprintordmorethanonce);
      $mconfig->msysinvdefaultcreditlimit = $request->msysinvdefaultcreditlimit;
      $mconfig->msysinvlptdirectprinting = $this->convertBoolean($request->msysinvlptdirectprinting);

      $mconfig->msyspurchrequest = $this->convertBoolean($request->msyspurchrequest);
      $mconfig->msyspurchorder = $this->convertBoolean($request->msyspurchorder);
      $mconfig->msyspurchinvoice = $this->convertBoolean($request->msyspurchinvoice);
      $mconfig->msyspurchcreditlimit = $this->convertBoolean($request->msyspurchcreditlimit);
      $mconfig->msyspurchinvfootnote = $request->msyspurchinvfootnote;
      $mconfig->msyspurchorderfootnote = $request->msyspurchorderfootnote;

      $mconfig->msysacccogmethod = $request->msysacccogmethod;
      $mconfig->msysaccstock = $request->msysaccstock;
      $mconfig->msysaccinv = $request->msysaccinv;
      $mconfig->msysaccreturninv = $request->msysaccreturninv;
      $mconfig->msysaccinvdisc = $request->msysaccinvdisc;
      $mconfig->msysaccsentgoods = $request->msysaccsentgoods;
      $mconfig->msysaccsellingexpense = $request->msysaccsellingexpense;
      $mconfig->msysaccreturnpurchase = $request->msysaccreturnpurchase;
      $mconfig->msysaccar = $request->msysaccar;
      $mconfig->msysaccpaidcapital = $request->msysaccpaidcapital;
      $mconfig->msysaccretainedearning = $request->msysaccretainedearning;

      $mconfig->msysbankminus = $this->convertBoolean($request->msysbankminus);

      $mconfig->msysinventmultiwarehouse = $this->convertBoolean($request->msysinventmultiwarehouse);
      $mconfig->msysinventmultiuom = $this->convertBoolean($request->msysinventmultiuom);
      $mconfig->msysinventuseserial = $this->convertBoolean($request->msysinventuseserial);
      $mconfig->msysinventallowminus = $this->convertBoolean($request->msysinventallowminus);
      $mconfig->msysinventslabprice = $this->convertBoolean($request->msysinventslabprice);

      $mconfig->save();
      return response()->json($mconfig);
    }

    public function logo(Request $request){

      $validator = Validator::make($request->all(),[
        'logo' => 'required|max:2000|mimes:png,jpg,jpeg'
      ]);

      if($validator->fails()){
        return response()->json('File harus berupa png atau jpg dengan ukuran < 2MB',403);
      } else {
        $logo = $request->file('logo');
        $filename = uniqid().'.'.$logo->extension();
        $logo->move('logo',$filename); //ke public logo
        $url = url('logo/'.$filename);
        $mconfig = MConfig::find(1);
        $mconfig->msyscomplogo = $url;
        $mconfig->save();
        return response()->json(array('url' => $url));
      }


    }
}
