<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Exception;
use Auth;
use App\MJournal;
use App\MCOA;
use DB;

class CashBankIncomeController extends Controller
{
    public function store(Request $request){
        try{
            DB::connection(Auth::user()->db_name)->beginTransaction();
            $from_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$request->from_account['mcoacode'])->first();
            foreach($request->to_accounts as $to_acc){
                    MJournal::record_journal("","Pemasukan",$request->from_account['mcoacode'],$to_acc['amount'],0,"","","");
                    MJournal::record_journal("","Pemasukan",$to_acc['mcoacode'],0,$to_acc['amount'],"","","");

                    $to_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$to_acc['mcoacode'])->first();

                    $from_coa->update_saldo('-',$to_acc['amount']);
                    $to_coa->update_saldo('+',$to_acc['amount']);

                    MJournal::add_prefix();
            }

            DB::connection(Auth::user()->db_name)->commit();
            return response()->json('ok');
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return response()->json('err',400);
        }
    }
}
