<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\MJournal;
use Carbon\Carbon;
use App\MCOA;

class JournalController extends Controller
{
    public function journal(Request $request){
        $journal_query = MJournal::on(Auth::user()->db_name)->where('void',0);
        if($request->has('end')){
            $journal_query->whereDate('created_at','<=',Carbon::parse($request->end));
        }
        $journals = $journal_query->get();
        foreach($journals as $j){
            $j['akun'] = MCOA::on(Auth::user()->db_name)->where('mcoacode',$j->mjournalcoa)->first();
        }
        return response()->json($journals);
    }
}
