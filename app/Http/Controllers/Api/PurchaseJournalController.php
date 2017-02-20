<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\MCOA;
use App\MJournal;
use Carbon\Carbon;

class PurchaseJournalController extends Controller
{
    public function index(Request $request){

        $header_query = MJournal::on(Auth::user()->db_name)->where('mjournaltranstype','Pembelian');

        if($request->has('start')){
            $header_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
        }
        if($request->has('end')){
            $header_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
        }

        $headers = $header_query->groupBy('mjournalid')->get();
        $groups = [];
        foreach($headers as $h){
            $detail_query = MJournal::on(Auth::user()->db_name)->where('mjournaltranstype','Pembelian')->where('mjournaltransno',$h->mjournaltransno);

            if($request->has('start')){
                $header_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
            }
            if($request->has('end')){
                $header_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
            }

            $details = $detail_query->get();

            $sum_debit = 0;
            $sum_credit = 0;

            foreach ($details as $d) {
                $d['mjournalcoaname'] = MCOA::on(Auth::user()->db_name)->where('mcoacode',$d->mjournalcoa)->first()->mcoaname;
                $sum_debit += $d->mjournaldebit;
                $sum_credit += $d->mjournalcredit;
            }

            $data = [
                'date' => $h->mjournaldate,
                'type' => $h->mjournaltranstype,
                'trans' => $h->mjournaltransno,
                'sum_debit' => $sum_debit,
                'sum_credit' => $sum_credit,
                'transactions' => $details
            ];

            array_push($groups,$data);
        }

        return response()->json($groups);

    }
}
