<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\MJournal;
use Carbon\Carbon;
use App\MCOA;

class LedgerController extends Controller
{
    public function ledgers(Request $request){
        $ledger_query = MJournal::on(Auth::user()->db_name);
        $coa ="";
        if($request->has('bank') && $request->bank != 'Semua'){
            $coa = MCOA::on(Auth::user()->db_name)->where('id',$request->bank)->first()->mcoacode;
        }
        if($request->has('start')){
            $ledger_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
        }

        if($request->has('end')){
            $ledger_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
        }

        if($request->has('bank') && $request->bank != 'Semua'){
            $ledger_query->where('mjournalcoa',$coa);
        }

        $ledgers = [];

        $ledger_group = $ledger_query->groupBy('mjournalcoa')->orderBy('created_at','asc')->get();

        foreach($ledger_group as $grp){
            $group_data_query = MJournal::on(Auth::user()->db_name)->where('mjournalcoa',$grp->mjournalcoa);
            $debit = 0;
            $credit = 0;
            if($request->has('start')){
                $group_data_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
            }
            if($request->has('end')){
                $group_data_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
            }
            $group_data = $group_data_query->get();
            foreach($group_data as $data){
                $data['data'] = true;
                $data['summary'] = false;
                $data['akun'] = MCOA::on(Auth::user()->db_name)->where('mcoacode',$data->mjournalcoa)->first();


                $debit += $data->mjournaldebit;
                $credit += $data->mjournalcredit;


                array_push($ledgers,$data);
            }
            $saldo = [
                'data' => false,
                'summary' => false,
                'debit' => $debit,
                'credit' => $credit
            ];
            array_push($ledgers,$saldo);
            if($debit > $credit){
                $summary = [
                    'data' => false,
                    'summary' => true,
                    'debit' => $debit - $credit,
                    'credit' => 0
                ];
            } else {
                $summary = [
                    'data' => false,
                    'summary' => true,
                    'debit' => 0,
                    'credit' => $credit - $debit
                ];
            }
            array_push($ledgers,$summary);
        }

        return response()->json($ledgers);
    }
}
