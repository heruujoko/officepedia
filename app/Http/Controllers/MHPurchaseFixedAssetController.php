<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MHPurchaseFixedAssetController extends Controller
{
    public function index(){
      $data['active'] = 'purchasefixedasset';
      $data['section'] = 'Pembelian Aset Tetap';
      return view('admin.purchasefixedasset',$data);
    }
}
