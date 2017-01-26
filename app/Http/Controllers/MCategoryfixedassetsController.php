<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MCategoryfixedassets;
use App\MCOA;
use Excel;
use PDF;
use Auth;
use App\Helper\DBHelper;

class MCategoryfixedassetsController extends Controller
{
    public function index(){
        if(Auth::user()->has_role('R_fixedasset')){
            DBHelper::configureConnection(Auth::user()->db_alias);
          	$data['mcoa'] = MCOA::on(Auth::user()->db_name)->get();
        	$data['active'] = 'categoryfixedassets';
    		$data['section'] = 'Kategori Asset Tetap';
        	$data['activetab'] = 1;
    		$data['MCategorygoods'] = MCategoryfixedassets::on(Auth::user()->db_name)->get();
    		$data['id'] = null;
    	    return view('admin/viewmcategoryfixedassets',$data);
        } else {
            return redirect('/admin-nano/index');
        }
	  }

	public function csv(){
    DBHelper::configureConnection(Auth::user()->db_alias);
		$this->mcategory = MCategoryfixedassets::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Kategori Aset Tetap',function($excel){
			$excel->sheet('Master Kategori Aset Tetap',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Kode Group','Nama Group','Umur Ekonomis (Tahun)','Mengalami Penyusutan','Metode Depresiasi','COA Harta','COA Akumulasi Penyusutan','COA Beban Penyusutan','Keterangan'
				));
				foreach($this->mcategory as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->mcategoryfixedassetgroupcode,$cust->mcategoryfixedassetgroupname,$cust->mcategoryfixedassetage,$cust->mcategoryfixedassetshrink,$cust->mcategoryfixedassetdepreciaton,$cust->mcategoryfixedassetcoaasset,$cust->mcategoryfixedassetcoaaccudepr,$cust->mcategoryfixedassetcoadeprexp,$cust->mcategoryfixedassetremark
					));
				}
			});
		})->export('csv');
	}
	public function excel(){
    DBHelper::configureConnection(Auth::user()->db_alias);
		$this->mcategory = MCategoryfixedassets::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Kategori Aset Tetap',function($excel){
			$excel->sheet('Master Kategori Aset Tetap',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Kode Group','Nama Group','Umur Ekonomis (Tahun)','Mengalami Penyusutan','Metode Depresiasi','COA Harta','COA Akumulasi Penyusutan','COA Beban Penyusutan','Keterangan'
				));
				foreach($this->mcategory as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->mcategoryfixedassetgroupcode,$cust->mcategoryfixedassetgroupname,$cust->mcategoryfixedassetage,$cust->mcategoryfixedassetshrink,$cust->mcategoryfixedassetdepreciaton,$cust->mcategoryfixedassetcoaasset,$cust->mcategoryfixedassetcoaaccudepr,$cust->mcategoryfixedassetcoadeprexp,$cust->mcategoryfixedassetremark
					));
				}
			});
		})->export('xls');
	}
	public function pdf(){
    DBHelper::configureConnection(Auth::user()->db_alias);
		$data['mcategory'] = MCategoryfixedassets::on(Auth::user()->db_name)->where('void',0)->get();
		$pdf = PDF::loadview('admin/export/mcategoryfixedassets',$data);
		return $pdf->setPaper('a3', 'landscape')->download('Master Kategori Aset Tetap.pdf');
	}
}
