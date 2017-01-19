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
            $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$request->bank)->first()->mcoacode;
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

        $ledger_group = $ledger_query->groupBy('mjournalid')->orderBy('created_at','asc')->where('void',0)->get();

        foreach($ledger_group as $l){
            $ledgers_per_journalid = [];
            $jt_query = MJournal::on(Auth::user()->db_name)->where('mjournalid',$l->mjournalid)->where('void',0);
            if($request->has('bank') && $request->bank != 'Semua'){
                $jt_query->where('mjournalcoa',$request->bank);
            }
            if($request->has('end')){
                $ledger_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
            }
            $journal_transactions = $jt_query->get();
            foreach ($journal_transactions as $jt){
                array_push($ledgers_per_journalid,$jt);
            }
            $data['transactions'] = $ledgers_per_journalid;
            $data['journalid'] = $ledgers_per_journalid[0]->mjournalid;
            if(sizeof($data['transactions']) > 0){
                array_push($ledgers,$data);
            }
        }

        return response()->json($ledgers);
    }
}
