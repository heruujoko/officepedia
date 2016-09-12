<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

//MODEL
use App\MBRANCH;
use App\MGOODS;

//DB
use DB;
//Addons
Use Alert;
use App;
class AdminController extends Controller
{
	public function getIndex(){
   		return view('admin/index');

	 }

	public function getCabang(){
		$a = DB::table('mbranch')->orderby('created_at','desc')->where('void', '0')->get();
		$data['a']=$a;
		return view('admin/viewcabang', $data);
	}

	public function getTambahcabang(){
		return view('admin/createcabang');
	}
	public function postTambahcabang(Request $request){
		$validator = Validator::make($request->all(),[
			'mbranchcode'=>'required|unique:mbranch',
			'mbranchname'=>'required',
			'address'=>'required',
			'phone'=>'required',
			'city'=>'required',
			'person_in_charge'=>'required',
			'information'=>'',
			'void'=>'',
			]);


		if ($validator->fails()) {

		 return redirect('admin-nano/cabang#main')->with('autofocus',true)->withInput()->withErrors($validator);;

		}
		else{
			$data = new MBRANCH();
			$data->mbranchcode = $request->input('mbranchcode');
			$data->mbranchname = $request->input('mbranchname');
			$data->address = $request->input('address');
			$data->phone = $request->input('phone');
			$data->city = $request->input('city');
			$data->person_in_charge = $request->input('person_in_charge');
			$data->information = $request->input('information');
			$data->void = $request->input('void');
			$data->save();
			Alert::success('Input Berhasil', 'Success');
			return redirect('admin-nano/cabang#tablembranch');


		}

		}
		// public function getEditcabang($id){
		// 	$a = MBRANCH::find($id);
		// 	$data['a']=$a;
		// 	return view('admin/editcabang',$data);

		// }

		// public function postEditcabang(Request $request, $id){

		// 		$validator = Validator::make($request->all(),[
		// 		'mbranchcode'=>'required|unique:mbranch,mbranchcode,'.$id,

		// 		]);
		// 		if ($validator->fails()) {
		// 		 return redirect()->back()->withErrors($validator);
		// 		}
		// 		else{
		// 			$id = $request->input('id');
		// 			$data = MBRANCH::find($id);
		// 			$data->mbranchcode = $request->input('mbranchcode');
		// 			$data->mbranchname = $request->input('mbranchname');
		// 			$data->address = $request->input('address');
		// 			$data->phone = $request->input('phone');
		// 			$data->city = $request->input('city');
		// 			$data->person_in_charge = $request->input('person_in_charge');
		// 			$data->information = $request->input('information');
		// 			$data->save();
		// 			Alert::success('Pengubahan berhasil')->persistent("OK");
		// 			return redirect('admin-nano/cabang');
		// }

		// }
	public function getDelcabang($id){

			$data = MBRANCH::find($id);
			DB::table('mbranch')->where('id',$id)->update(['void' => '1']);
			

			return redirect('admin-nano/cabang#main');
		
	
	return redirect('admin-nano/cabang');
	}


	// public function getViewcabang($id){
	// 	$a = MBRANCH::find($id);
	// 	$data['a']=$a;
	// 	return view('admin/detailcabang',$data);
	// }


	public function getBarang(){
		$a = MGOODS::all();
		$data['a']=$a;
		return view('admin/viewbarang',$data);
	}

	public function getPelanggan(){
		// $a = PELANGGAN::all();
		// $data['a']=$a;
		return view('admin/viewpelanggan');
	}
	 
	// public function getTambahbarang(){
	// 	return view('admin/createbarang');
	// }
	// public function postTambahbarang(Request $request){
	// 	$validator = Validator::make($request->all(),[
	// 		'mgoodscode'=>'required',
	// 		'mgoodsbarcode'=>'',
	// 		'mgoodsname'=>'required',
	// 		'mgoodsalias'=>'',
	// 		'mgoodstype'=>'',
	// 		'mgoodsbrand'=>'',
	// 		'mgoodsgroup1'=>'',
	// 		'mgoodsgroup2'=>'',
	// 		'mgoodsgroup3'=>'',
	// 		'mgoodsremark'=>'',
	// 		'mgoodsunit'=>'',
	// 		'mgoodsunit2'=>'',
	// 		'mgoodsunit3'=>'',
	// 		'mgoodssuppliercode'=>'',
	// 		'mgoodssuppliername'=>'',
	// 		'mgoodspricein'=>'',
	// 		'mgoodspriceout'=>'required',
	// 		'mgoodcoapurchasing'=>'',
	// 		'mgoodscoapurchasingname'=>'',
	// 		'mgoodscoacogs'=>'',
	// 		'mgoodscoacogsname'=>'',
	// 		'mgoodscoaselling'=>'',
	// 		'mgoodscoasellingname'=>'',
	// 		'mgoodscoareturnofselling'=>'',
	// 		'mgoodscoareturnofsellingname'=>'',
	// 		'mgoodscogs'=>'',
	// 		'mgoodsactive'=>'',
	// 		'mgoodsuniquetransaction'=>'',
	// 		'mgoodsbranches'=>'',
	// 		'mgoodspicture'=>'',
	// 		'mgoodsunit2convert'=>'',
	// 		'mgoodsunit3convert'=>'',
	// 		]);
	// 		if ($validator->fails()) {
	// 		 return redirect()->back()->withErrors($validator);
	// 		}
	// 		else{
	// 			$data = new MGOODS();
	// 			$data->mgoodscode = $request->input('mgoodscode');
	// 			$data->mgoodsbarcode = $request->input('mgoodsbarcode');
	// 			$data->mgoodsname = $request->input('mgoodsname');
	// 			$data->mgoodsalias = $request->input('mgoodsalias');
	// 			$data->mgoodstype = $request->input('mgoodstype');
	// 			$data->mgoodsbrand = $request->input('mgoodsbrand');
	// 			$data->mgoodsgroup1 = $request->input('mgoodsgroup1');
	// 			$data->mgoodsgroup2 = $request->input('mgoodsgroup2');
	// 			$data->mgoodsgroup3 = $request->input('mgoodsgroup3');
	// 			$data->mgoodsremark = $request->input('mgoodsremark');
	// 			$data->mgoodsunit = $request->input('mgoodsunit');
	// 			$data->mgoodsunit2 = $request->input('mgoodsunit2');
	// 			$data->mgoodsunit3 = $request->input('mgoodsunit3');
	// 			$data->mgoodssuppliercode = $request->input('mgoodssuppliercode');
	// 			$data->mgoodssuppliername = $request->input('mgoodssuppliername');
	// 			$data->mgoodspricein = $request->input('mgoodspricein');
	// 			$data->mgoodspriceout = $request->input('mgoodspriceout');
	// 			$data->mgoodcoapurchasing = $request->input('mgoodscoapurchasingname');
	// 			$data->mgoodscoapurchasingname = $request->input('mgoodscoapurchasingname');
	// 			$data->mgoodscoacogs = $request->input('mgoodscoacogsname');
	// 			$data->mgoodscoacogsname = $request->input('mgoodscoacogsname');
	// 			$data->mgoodscoaselling = $request->input('mgoodscoasellingname');
	// 			$data->mgoodscoasellingname = $request->input('mgoodscoasellingname');
	// 			$data->mgoodscoareturnofselling = $request->input('mgoodscoareturnofsellingname');
	// 			$data->mgoodscoareturnofsellingname = $request->input('mgoodscoareturnofsellingname');
	// 			$data->mgoodscogs = $request->input('mgoodscogs');
	// 			$data->mgoodsactive = $request->input('mgoodsactive');
	// 			$data->mgoodsuniquetransaction = $request->input('mgoodsuniquetransaction');
	// 			$data->mgoodsbranches = $request->input('mgoodsbranches');
	// 			$data->mgoodspicture = $request->input('mgoodspicture');
	// 			$data->mgoodsunit2convert = $request->input('mgoodsunit2convert');
	// 			$data->mgoodsunit3convert = $request->input('mgoodsunit3convert');
	// 			$data->save();
	// 			return redirect('admin-nano/barang');
	// 			}
	// 		}

	// public function getEditbarang($id){
	// 	$a = MGOODS::find($id);
	// 	$data['a']=$a;
	// 	return view('admin/editbarang', $data);
	// }
	// public function postEditbarang(Request $request){
	// 	$validator = Validator::make($request->all(),[
	// 		'mgoodscode'=>'required',
	// 		'mgoodsbarcode'=>'',
	// 		'mgoodsname'=>'required',
	// 		'mgoodsalias'=>'',
	// 		'mgoodstype'=>'',
	// 		'mgoodsbrand'=>'',
	// 		'mgoodsgroup1'=>'',
	// 		'mgoodsgroup2'=>'',
	// 		'mgoodsgroup3'=>'',
	// 		'mgoodsremark'=>'',
	// 		'mgoodsunit'=>'',
	// 		'mgoodsunit2'=>'',
	// 		'mgoodsunit3'=>'',
	// 		'mgoodssuppliercode'=>'',
	// 		'mgoodssuppliername'=>'',
	// 		'mgoodspricein'=>'',
	// 		'mgoodspriceout'=>'required',
	// 		'mgoodcoapurchasing'=>'',
	// 		'mgoodscoapurchasingname'=>'',
	// 		'mgoodscoacogs'=>'',
	// 		'mgoodscoacogsname'=>'',
	// 		'mgoodscoaselling'=>'',
	// 		'mgoodscoasellingname'=>'',
	// 		'mgoodscoareturnofselling'=>'',
	// 		'mgoodscoareturnofsellingname'=>'',
	// 		'mgoodscogs'=>'',
	// 		'mgoodsactive'=>'',
	// 		'mgoodsuniquetransaction'=>'',
	// 		'mgoodsbranches'=>'',
	// 		'mgoodspicture'=>'',
	// 		'mgoodsunit2convert'=>'',
	// 		'mgoodsunit3convert'=>'',
	// 		]);
	// 		if ($validator->fails()) {
	// 		 return redirect()->back()->withErrors($validator);
	// 		}
	// 		else{
	// 			$id = $request->input('id');
	// 			$data = MGOODS::find($id);
	// 			$data->mgoodscode = $request->input('mgoodscode');
	// 			$data->mgoodsbarcode = $request->input('mgoodsbarcode');
	// 			$data->mgoodsname = $request->input('mgoodsname');
	// 			$data->mgoodsalias = $request->input('mgoodsalias');
	// 			$data->mgoodstype = $request->input('mgoodstype');
	// 			$data->mgoodsbrand = $request->input('mgoodsbrand');
	// 			$data->mgoodsgroup1 = $request->input('mgoodsgroup1');
	// 			$data->mgoodsgroup2 = $request->input('mgoodsgroup2');
	// 			$data->mgoodsgroup3 = $request->input('mgoodsgroup3');
	// 			$data->mgoodsremark = $request->input('mgoodsremark');
	// 			$data->mgoodsunit = $request->input('mgoodsunit');
	// 			$data->mgoodsunit2 = $request->input('mgoodsunit2');
	// 			$data->mgoodsunit3 = $request->input('mgoodsunit3');
	// 			$data->mgoodssuppliercode = $request->input('mgoodssuppliercode');
	// 			$data->mgoodssuppliername = $request->input('mgoodssuppliername');
	// 			$data->mgoodspricein = $request->input('mgoodspricein');
	// 			$data->mgoodspriceout = $request->input('mgoodspriceout');
	// 			$data->mgoodcoapurchasing = $request->input('mgoodscoapurchasingname');
	// 			$data->mgoodscoapurchasingname = $request->input('mgoodscoapurchasingname');
	// 			$data->mgoodscoacogs = $request->input('mgoodscoacogsname');
	// 			$data->mgoodscoacogsname = $request->input('mgoodscoacogsname');
	// 			$data->mgoodscoaselling = $request->input('mgoodscoasellingname');
	// 			$data->mgoodscoasellingname = $request->input('mgoodscoasellingname');
	// 			$data->mgoodscoareturnofselling = $request->input('mgoodscoareturnofsellingname');
	// 			$data->mgoodscoareturnofsellingname = $request->input('mgoodscoareturnofsellingname');
	// 			$data->mgoodscogs = $request->input('mgoodscogs');
	// 			$data->mgoodsactive = $request->input('mgoodsactive');
	// 			$data->mgoodsuniquetransaction = $request->input('mgoodsuniquetransaction');
	// 			$data->mgoodsbranches = $request->input('mgoodsbranches');
	// 			$data->mgoodspicture = $request->input('mgoodspicture');
	// 			$data->mgoodsunit2convert = $request->input('mgoodsunit2convert');
	// 			$data->mgoodsunit3convert = $request->input('mgoodsunit3convert');
	// 			$data->save();
	// 			return redirect('admin-nano/barang');
	// 			}
	// }

	// public function getDelbarang($id){
	// 	$data = MGOODS::find($id);
	// 	$data->delete();
	// return redirect('admin-nano/barang');
	// }
	// public function getTest(){
	// 	$pdf = App::make('dompdf.wrapper');
	// 	$pdf->loadHTML('<h1>Test</h1>');
	// 	return $pdf->stream();
	// }

}
