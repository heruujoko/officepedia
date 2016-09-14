<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;

use App\Http\Requests;
use Response;

//MODEL
use App\MBRANCH;
use App\MGOODS;

use Validator;
class ApiController extends Controller
{

    private $iteration;

    public function getIndex(){
    	echo 'Forbidden';
    }

    public function getDatacabang(){

        $this->iteration = 0;
        $mbranch = MBRANCH::where('void', '0')->orderby('created_at','desc')->get();
        return Datatables::of($mbranch)->addColumn('action', function($mbranch){
          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewbranch('.$mbranch->id.')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editbranch('.$mbranch->id.')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete('.$mbranch->id.')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($mbranch){
            $this->iteration++;
            return "<span>".$this->iteration."</span>";
        })
        ->make(true);


    }

// API
    public function getViewcabang($id){
        try{
            $data = MBRANCH::find($id);
            $statuscode = 200;
            $response = ["mbranch" => [
            'id' => (int) $id,
            'mbranchcode' => $data->mbranchcode,
            'mbranchname' => $data->mbranchname,
            'address' => $data->address,
            'phone' => $data->phone,
            'city' => $data->city,
            'person_in_charge' => $data->person_in_charge,
            'information' => $data->information,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at
            ]];
        }
        finally{
            return Response::json($response, $statuscode);
        }
    }

    public function getEditcabang($id){
    	try{
    		$data = MBRANCH::find($id);
    		$statuscode = 200;
    		$response = [ "mbranch" => [
    		'id' => (int) $id,
    		'mbranchcode' => $data->mbranchcode,
    		'mbranchname' => $data->mbranchname,
    		'address' => $data->address,
    		'phone' => $data->phone,
    		'city' => $data->city,
    		'person_in_charge' => $data->person_in_charge,
    		'information' => $data->information,

            ] ];
     }
        finally{
        return Response::json($response, $statuscode);
        }
    }

    public function postEditcabang(Request $request, $id){
        $statuscode = 400;
        $sukses = 200;
        $validator = Validator::make($request->all(),[
        'mbranchcode'=>'required|unique:mbranch,mbranchcode,'.$id,

        ]);

    if ($validator->fails()) {

       return Response::json(array(
        'errors'=>$validator->messages()->all(),
        'code' =>$statuscode
        ));

    }
   else
        $data = MBRANCH::find($id);
        $data->mbranchcode = $request->input('mbranchcode');
        $data->mbranchname = $request->input('mbranchname');
        $data->address = $request->input('address');
        $data->phone = $request->input('phone');
        $data->city = $request->input('city');
        $data->person_in_charge = $request->input('person_in_charge');
        $data->information = $request->input('information');
        $data->save();
        return $sukses;


}
// API

}
