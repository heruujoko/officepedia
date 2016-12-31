<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\MConfig;

use App\MHPurchasequotation;

use App\MDPurchasequotation;

use App\MSupplier;

Use Auth;

Use PDF;
class PurchasequotationController extends Controller
{
    public function index(){
        $data['config'] = MConfig::on(Auth::user()->db_name)->first();
        
        $data['active'] = 'purchaseinvoice';
        $data['section'] = 'Transaksi Pembelian';
        return view('admin.purchasequotation',$data);
    }

    public function print2(){
    	$data['config'] = MConfig::on(Auth::user()->db_name)->first();
    	$data['quotation'] = MHPurchasequotation::on(Auth::user()->db_name)->first();
        $data['mdquotation'] = MDPurchasequotation::on(Auth::user()->db_name)->first();
        $data['supplier'] = MSupplier::on(Auth::user()->db_name)->first();
		$pdf = PDF::loadview('admin/export/purchasequotation',$data);
		return $pdf->setPaper('a4', 'potrait')->stream('Master Purchase Quotation.pdf');
    }
}
