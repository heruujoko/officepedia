<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\MJournal;
use Carbon\Carbon;
use App\MCOA;
use App\MBRANCH;

class LedgerController extends Controller
{
    public function ledgers(Request $request){

        $coa = base64_decode($request->coa);
        $coa = json_decode($coa);

        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();

        $group_data = [];

        foreach($coa as $c){
            $ledger_query = MJournal::on(Auth::user()->db_name)->where('mjournalcoa',$c);

            if($request->has('start')){
                $ledger_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
            }

            if($request->has('end')){
                $ledger_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
            }

            $ledger_query->where('mjournalbranchcode',$branch->mbranchcode);

            $data = $ledger_query->get();

            foreach($data as $d){
              $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$d->mjournalcoa)->first();
              $d['coaname'] = $coa->mcoaname;
            }

            $mcoa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$c)->first();

            $group = [
                'mcoacode' => $c,
                'mcoaname' => $mcoa->mcoaname,
                'last_saldo' => $this->account_last_saldo($c,$request->start),
                'transactions' => $data
            ];

            array_push($group_data,$group);
        }

        return response()->json($group_data);
    }

    private function account_last_saldo($coa,$offset){
        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();
        $first_day =  Carbon::parse(date('Y-01-01'));
        if($first_day->diffInDays(Carbon::parse($offset)) > 0){
            $debit = 0;
            $credit = 0;
            $journal_data = MJournal::on(Auth::user()->db_name)->where('mjournalcoa',$coa)->whereDate('mjournaldate','<',Carbon::parse($offset))->where('mjournalbranchcode',$branch->mbranchcode)->get();
            foreach($journal_data as $j){
                $debit += $j->mjournaldebit;
                $credit += $j->mjournalcredit;
            }

            return ($debit - $credit);
        } else {
            return 0;
        }

    }

}
