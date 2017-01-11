<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\MJournal;
use Carbon\Carbon;
use App\MCOA;
use Datatables;
use App\MConfig;

class JournalController extends Controller
{

    private $iteration;

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

    public function group_journal($type){
        $grp = MJournal::on(Auth::user()->db_name)->where('void',0)->where('mjournaltranstype',$type)->groupBy('mjournalid')
        ->selectRaw('*,sum(mjournalcredit) as total_credit, sum(mjournaldebit) as total_debit')
        ->get();

        $config = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        $this->decimals = $config->msysgenrounddec;
        $this->dec_point = $config->msysnumseparator;
        if($this->dec_point == ","){
          $this->thousands_sep = ".";
        } else {
          $this->thousands_sep = ",";
        }

        return Datatables::of($grp)->addColumn('action', function($j){

          return '<center><div class="button">
          <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewincome(\''.$j->mjournalid.'\')"> <font style="">Lihat</font></a>
          <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editincome(\''.$j->mjournalid.'\')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
          <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete(\''.$j->mjournalid.'\')">
        <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($j){
            $this->iteration++;
            return "<span style=\"float:right\">".$this->iteration."</span>";
        })->addColumn('credits',function($j){
            return "<span style=\"float:right;\">".number_format($j->total_credit,$this->decimals,$this->dec_point,$this->thousands_sep)."</span>";
        })->addColumn('debits',function($j){
            return "<span style=\"float:right;\">".number_format($j->total_debit,$this->decimals,$this->dec_point,$this->thousands_sep)."</span>";
        })
        ->make(true);
    }
}
