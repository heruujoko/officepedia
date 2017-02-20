<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\MCOA;
use App\MJournal;
use Carbon\Carbon;

class CashBalanceReport extends Controller
{
    public function index(Request $request){
        $mcoa = MCOA::on(Auth::user()->db_name)->get();
        $filtered_coa = [];
        foreach($mcoa as $coa){
            $sum_debit = 0;
            $sum_credit = 0;
            $journal_query = MJournal::on(Auth::user()->db_name)->where('mjournalcoa',$coa->mcoacode);

            if($request->has('start')){
                $journal_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
            }
            if($request->has('end')){
                $journal_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
            }

            $journals = $journal_query->get();

            foreach($journals as $j){
                $sum_debit += $j->mjournaldebit;
                $sum_credit += $j->mjournalcredit;
            }

            $coa['sum_debit'] = $sum_debit;
            $coa['sum_credit'] = $sum_credit;

            if($request->notzero == "true"){
                // dd(($sum_debit != 0) && ($sum_credit != 0));
                if(($sum_debit != 0) || ($sum_credit != 0)){
                    array_push($filtered_coa,$coa);
                }
            } else {
                array_push($filtered_coa,$coa);
            }
        }

        return response()->json($filtered_coa);
    }
}
