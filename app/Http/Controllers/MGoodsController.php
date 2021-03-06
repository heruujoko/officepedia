<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\MGoods;
use App\MCOA;
use App\MSupplier;
use Excel;
use PDF;
use App\MGoodsMark;
use App\MCategorygoods;
use App\MTax;
use App\MGoodssubtype;
use App\MGoodstype;
use App\MUnit;
use Auth;

class MGoodsController extends Controller
{
    public function index(){

        if(Auth::user()->has_role('R_goods')){
            $data['active'] = 'barang';
    		    $data['mcoa'] = MCOA::on(Auth::user()->db_name)->get();
            $data['marks'] = MGoodsMark::on(Auth::user()->db_name)->get();
            $data['categories'] = MCategorygoods::on(Auth::user()->db_name)->get();
    		    $data['msupplier'] = MSupplier::on(Auth::user()->db_name)->get();
            $data['types'] = MGoodstype::on(Auth::user()->db_name)->get();
            $data['subtypes'] = MGoodssubtype::on(Auth::user()->db_name)->get();
            $data['taxes'] = MTax::on(Auth::user()->db_name)->get();
            $data['units'] = MUnit::on(Auth::user()->db_name)->where('void',0)->get();
            $data['displays'] = [
                ['code' => 'all', 'label' => 'Pembelian Penjualan'],
                ['code' => 'purchase', 'label' => 'Pembelian'],
                ['code' => 'sales', 'label' => 'Penjualan']
            ];
    		return view('admin/viewmgoods',$data);
        } else{
            return redirect('/admin-nano/index');
        }

	}
	public function csv(){
		$this->mgoods = MGoods::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Barang',function($excel){
			$excel->sheet('Master Barang',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
					'Kode Barang','Barcode','Nama Barang','Nama Barang Alias','Keterangan','Satruan-1','Satruan-2','Satruan-3','Status','Harga Beli','Harga Jual','Tipe Barang','Merk','Group Barang 1','Group Barang 2','Group Barang 3','Nama Supplier','Supplier','Digunakan Oleh Semua Orang','Unique Transaction','Pembelian','Nama Pembelian','Hpp','Nama Hpp','Penjualan','Nama Penjualan','Retur Penjualan','Nama Retur Penjualan'
				));
				foreach($this->mgoods as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->mgoodscode,$cust->mgoodsbarcode,$cust->mgoodsname,$cust->mgoodsalias,$cust->mgoodsremark,$cust->mgoodsunit,$cust->mgoodsunit2,$cust->mgoodsunit3,$cust->mgoodsactive,$cust->mgoodspricein,$cust->mgoodspriceout,$cust->mgoodstype,$cust->mgoodsbrand,$cust->mgoodsgroup1,$cust->mgoodsgroup2,$cust->mgoodsgroup3,$cust->mgoodssuppliercode,$cust->mgoodssuppliername,$cust->mgoodsbranches,$cust->mgoodsuniquetransaction,$cust->mgoodcoapurchasing,$cust->mgoodscoapurchasingname,$cust->mgoodscoacogs,$cust->mgoodscoacogsname,$cust->mgoodscoaselling,$cust->mgoodscoasellingname,$cust->mgoodscoareturnofselling,$cust->mgoodscoareturnofsellingname,$cust->mgoodscogs
					));
				}
			});
		})->export('csv');
	}

	public function excel(){
		$this->customer = MGoods::on(Auth::user()->db_name)->where('void',0)->get();
		$this->count = 0;
		return Excel::create('Master Barang',function($excel){
			$excel->sheet('Master Barang',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
										'Kode Barang','Barcode','Nama Barang','Nama Barang Alias','Keterangan','Satruan-1','Satruan-2','Satruan-3','Status','Harga Beli','Harga Jual','Tipe Barang','Merk','Group Barang 1','Group Barang 2','Group Barang 3','Nama Supplier','Supplier','Digunakan Oleh Semua Orang','Unique Transaction','Pembelian','Nama Pembelian','Hpp','Nama Hpp','Penjualan','Nama Penjualan','Retur Penjualan','Nama Retur Penjualan'

				));
				foreach($this->customer as $cust){
					$this->count++;
					$sheet->row($this->count,array(
						$cust->mgoodscode,$cust->mgoodsbarcode,$cust->mgoodsname,$cust->mgoodsalias,$cust->mgoodsremark,$cust->mgoodsunit,$cust->mgoodsunit2,$cust->mgoodsunit3,$cust->mgoodsactive,$cust->mgoodspricein,$cust->mgoodspriceout,$cust->mgoodstype,$cust->mgoodsbrand,$cust->mgoodsgroup1,$cust->mgoodsgroup2,$cust->mgoodsgroup3,$cust->mgoodssuppliercode,$cust->mgoodssuppliername,$cust->mgoodsbranches,$cust->mgoodsuniquetransaction,$cust->mgoodcoapurchasing,$cust->mgoodscoapurchasingname,$cust->mgoodscoacogs,$cust->mgoodscoacogsname,$cust->mgoodscoaselling,$cust->mgoodscoasellingname,$cust->mgoodscoareturnofselling,$cust->mgoodscoareturnofsellingname,$cust->mgoodscogs
					));
				}
			});
		})->export('xls');
	}

	public function pdf(){
		$data['mgoods'] = MGoods::on(Auth::user()->db_name)->where('void',0)->get();
		$pdf = PDF::loadview('admin/export/mgoodspdf',$data);
		return $pdf->setPaper('a3', 'landscape')->download('Master Barang.pdf');
	}

    public function pricelist(){
        $this->goods = MGoods::on(Auth::user()->db_name)->get();
        $this->count = 0;
        return Excel::create('import_harga',function($excel){
			$excel->sheet('import_harga',function($sheet){
				$this->count++;
				$sheet->row($this->count,array(
				    'Kode Barang','Harga Jual'
				));
				foreach($this->goods as $g){
					$this->count++;
					$sheet->row($this->count,array(
						$g->mgoodscode,
                        $g->mgoodspriceout
					));
				}
			});
		})->export('xls');
    }

}
