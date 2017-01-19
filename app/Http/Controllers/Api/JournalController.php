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

        if($type == 'umum'){
            $type = "Jurnal Umum";
        }

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
            $this->journals = MJournal::on(Auth::user()->db_name)->where('mjournalid',$j->mjournalid)->where('void',0)->orderBy('id','asc')->get();
          return '<center><div class="button">
            <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewincome(\''.$j->mjournalid.'\')"> <font style="">Lihat</font></a>
            <a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editincome(\''.$j->mjournalid.'\')"> <font style="font-family: arial;">Ubah &nbsp</font></a>
            <a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete(\''.$j->mjournalid.'\')">
            <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
        })->addColumn('no',function($j){
            $this->iteration++;
            return "<span style=\"float:right\">".$this->iteration."</span>";
        })->addColumn('credits',function($j){
            $html_str = "<div>";
            foreach($this->journals as $cjr){
                if($cjr->mjournaldebit != 0){
                    $html_str.="<span style=\"float:left;\">".number_format($cjr->mjournalcredit,$this->decimals,$this->dec_point,$this->thousands_sep)."</span><br><br>";
                } else {
                    $html_str.="<span style=\"float:right;\">".number_format($cjr->mjournalcredit,$this->decimals,$this->dec_point,$this->thousands_sep)."</span><br><br>";
                }
            }
            $html_str.="</div>";
            return $html_str;
        })->addColumn('debits',function($j){
            $html_str = "<div>";
            foreach($this->journals as $djr){
                if($djr->mjournaldebit != 0){
                    $html_str.="<span style=\"float:left;\">".number_format($djr->mjournaldebit,$this->decimals,$this->dec_point,$this->thousands_sep)."</span><br><br>";
                } else {
                    $html_str.="<span style=\"float:right;\">".number_format($djr->mjournaldebit,$this->decimals,$this->dec_point,$this->thousands_sep)."</span><br><br>";
                }
            }
            $html_str.="</div>";
            return $html_str;
        })->addColumn('accounttrace',function($j){
            $html_str = "<div>";
            foreach($this->journals as $jr){
                $account = MCOA::on(Auth::user()->db_name)->where('mcoacode',$jr->mjournalcoa)->first();
                if($jr->mjournaldebit != 0){
                    $html_str.="<span style=\"float:left;\">".$jr->mjournalcoa." - ".$account->mcoaname." "."</span><br><br>";
                } else {
                    $html_str.="<span style=\"float:right;\">".$jr->mjournalcoa." - ".$account->mcoaname." "."</span><br><br>";
                }
            }
            $html_str.="</div>";
            return $html_str;
        })
        ->make(true);
    }
}
