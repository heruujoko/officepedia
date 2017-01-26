<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Excel;
use PDF;
use App\MSupplier;
use App\MCOA;
use App\MCategorysupplier;
use Auth;
use App\Helper\DBHelper;

class MSupplierController extends Controller
{
    private $count = 0;
	private $supplier = array();

	public function index(){

        if(Auth::user()->has_role('R_supplier')){
            $data['active'] = 'supplier';
    		$data['section'] = 'supplier';
            $data['activetab'] = 1;
    		$data['mcoa'] = MCOA::all();
            $data['categories'] = MCategorysupplier::on(Auth::user()->db_name)->get();
    		$data['id'] = null;
    	    return view('admin/viewmsupplier',$data);
        } else {
            return redirect('/admin-nano/index');
        }
}
	 public function store(){
		$new_supplier = new MCust;
		$new_supplier->name = $request->name;
		$new_supplier->save();
		if($request->chk){
			$prefix = MPrefix::where('type','Master Supplier')->first();
			$new_supplier->id_pelanggan = $prefix->name.'-'.$prefix->last_count;
			$prefix->last_count++;
			$new_supplier->save();
			$prefix->save();
		} else {
			$new_supplier->id_pelanggan = $request->id_pelanggan;
			$new_supplier->save();
		}
    $data['activetab'] = 1;
		$data['id'] = null;
	  return view('admin/viewmsupplier',$data);
	}
	public function editmsupplier($id, $activetab){
		$data['active'] = 'supplier';
		$data['section'] = 'supplier';
		$data['activetab'] = $activetab;
		$data['id'] = $id;
	  return view('admin/viewmsupplier',$data);
	}
	public function csv(){
		$this->supplier = MSupplier::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Supplier',function($excel){
			$excel->sheet('Master Supplier',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'ID Supplier','Nama Supplier','Email','Phone','Fax','Website','Alamat','Kota','Kode Pos','Provinsi','Negara','Nama Kontak','Posisi','Email Kontak','Handphone','Limit','Akun','TOP','Maksimum Nota','Default'
				));
				foreach($this->supplier as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->mcsupplierid,$cust->msuppliername,$cust->msupplieremail,$cust->msupplierphone,$cust->msupplierfax,$cust->msupplierwebsite,$cust->msupplieraddress,$cust->msuppliercity,$cust->msupplierzipcode,$cust->msupplierprovince,$cust->msuppliercountry,$cust->msuppliercontactname,$cust->msuppliercontactposition,$cust->msuppliercontactemail,$cust->msuppliercontactemailphone,$cust->msupplierarlimit,$cust->akun()->mcoaname,$cust->msuppliertop,$cust->msuppliermax,$cust->msupplierdefaultar
					));
				}
			});
		})->export('csv');
		}
	public function excel(){
		$this->supplier = MSupplier::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Supplier',function($excel){
			$excel->sheet('Master Supplier',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'ID Supplier','Nama Supplier','Email','Phone','Fax','Website','Alamat','Kota','Kode Pos','Provinsi','Negara','Nama Kontak','Posisi','Email Kontak','Handphone','Limit','Akun','TOP','Maksimum Nota','Default'
				));
				foreach($this->supplier as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->mcsupplierid,$cust->msuppliername,$cust->msupplieremail,$cust->msupplierphone,$cust->msupplierfax,$cust->msupplierwebsite,$cust->msupplieraddress,$cust->msuppliercity,$cust->msupplierzipcode,$cust->msupplierprovince,$cust->msuppliercountry,$cust->msuppliercontactname,$cust->msuppliercontactposition,$cust->msuppliercontactemail,$cust->msuppliercontactemailphone,$cust->msupplierarlimit,$cust->akun()->mcoaname,$cust->msuppliertop,$cust->msuppliermax,$cust->msupplierdefaultar
					));
				}
			});
		})->export('xls');
		}
	public function pdf(){
		$data['supplier'] = MSupplier::on(Auth::user()->db_name)->where('void',0)->get();
		$pdf = PDF::loadview('admin/export/msupplierpdf',$data);
		return $pdf->setPaper('a4', 'landscape')->download('Master Pelanggan.pdf');
	}

}
