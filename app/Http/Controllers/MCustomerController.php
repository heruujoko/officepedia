<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Excel;
use PDF;
use App\MCUSTOMER;
use App\MCOA;

class MCustomerController extends Controller
{
	private $count = 0;
	private $customer = array();

	public function index(){
		$data['active'] = 'customer';
		$data['section'] = 'customer';
    	$data['activetab'] = 1;
		$data['mcoa'] = MCOA::all();
		$data['id'] = null;
	  return view('admin/viewmcustomer',$data);
	}

	public function store(){
		$new_cust = new MCust;
		$new_cust->name = $request->name;
		$new_cust->save();
		if($request->chk){
			$prefix = MPrefix::where('type','Master Customer')->first();
			$new_cust->id_pelanggan = $prefix->name.'-'.$prefix->last_count;
			$prefix->last_count++;
			$new_cust->save();
			$prefix->save();
		} else {
			$new_cust->id_pelanggan = $request->id_pelanggan;
			$new_cust->save();
		}
    $data['activetab'] = 1;
		$data['id'] = null;
	  return view('admin/viewmcustomer',$data);
	}

	public function editmcustomercontact($id, $activetab){
		$data['active'] = 'customer';
		$data['section'] = 'customer';
		$data['activetab'] = $activetab;
		$data['id'] = $id;
	  return view('admin/viewmcustomer',$data);
	}

	public function csv(){
		$this->customer = MCUSTOMER::where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Pelanggan',function($excel){
			$excel->sheet('Master Pelanggan',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'ID Pelanggan','Nama Pelanggan','Email','Phone','Fax','Website','Alamat','Kota','Kode Pos','Provinsi','Negara','Nama Kontak','Posisi','Email Kontak','Handphone','Limit','Akun','TOP','Maksimum Nota','Default'
				));
				foreach($this->customer as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->mcustomerid,$cust->mcustomername,$cust->mcustomeremail,$cust->mcustomerphone,$cust->mcustomerfax,$cust->mcustomerwebsite,$cust->mcustomeraddress,$cust->mcustomercity,$cust->mcustomerzipcode,$cust->mcustomerprovince,$cust->mcustomercountry,$cust->mcustomercontactname,$cust->mcustomercontactposition,$cust->mcustomercontactemail,$cust->mcustomercontactemailphone,$cust->mcustomerarlimit,$cust->akun->mcoaname,$cust->mcustomertop,$cust->mcustomermax,$cust->mcustomerdefaultar
					));
				}
			});
		})->export('csv');
	}

	public function excel(){
		$this->customer = MCUSTOMER::where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Pelanggan',function($excel){
			$excel->sheet('Master Pelanggan',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'ID Pelanggan','Nama Pelanggan','Email','Phone','Fax','Website','Alamat','Kota','Kode Pos','Provinsi','Negara','Nama Kontak','Posisi','Email Kontak','Handphone','Limit','Akun','TOP','Maksimum Nota','Default'
				));
				foreach($this->customer as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->mcustomerid,$cust->mcustomername,$cust->mcustomeremail,$cust->mcustomerphone,$cust->mcustomerfax,$cust->mcustomerwebsite,$cust->mcustomeraddress,$cust->mcustomercity,$cust->mcustomerzipcode,$cust->mcustomerprovince,$cust->mcustomercountry,$cust->mcustomercontactname,$cust->mcustomercontactposition,$cust->mcustomercontactemail,$cust->mcustomercontactemailphone,$cust->mcustomerarlimit,$cust->akun->mcoaname,$cust->mcustomertop,$cust->mcustomermax,$cust->mcustomerdefaultar
					));
				}
			});
		})->export('xlsx');
	}

	public function pdf(){
		$data['customer'] = MCUSTOMER::where('void',0)->get();
		$pdf = PDF::loadview('admin/export/mcustomerpdf',$data);
		return $pdf->setPaper('a4', 'landscape')->download('Master Pelanggan.pdf');
	}

}
