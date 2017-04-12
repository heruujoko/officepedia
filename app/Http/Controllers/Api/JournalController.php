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

    public function trans_types(){
      $trans_types = [
          'Pembelian',
          'Penjualan',
          'Pemasukan',
          'Pengeluaran',
          'Transfer',
          'Umum'
      ];
      return response()->json($trans_types);
    }

    public function journal(Request $request){

        $journal_query = MJournal::on(Auth::user()->db_name)->where('void',0);
        if($request->has('start')){
            $journal_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
        }
        if($request->has('end')){
            $journal_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
        }

        if($request->has('type')){
            $journal_query->where('mjournaltranstype',$request->type);
        }

        $headers = $journal_query->groupBy('mjournalid')->get();
        $journals = [];
        foreach($headers as $h){
            $group_query = MJournal::on(Auth::user()->db_name)->where('mjournalid',$h->mjournalid);

            if($request->has('start')){
                $journal_query->whereDate('mjournaldate','>=',Carbon::parse($request->start));
            }
            if($request->has('end')){
                $journal_query->whereDate('mjournaldate','<=',Carbon::parse($request->end));
            }

            if($request->has('type')){
                $journal_query->where('mjournaltranstype',$request->type);
            }

            $groups = $group_query->orderBy('mjournaldebit','desc')->get();

            $sum_debit = 0;
            $sum_credit = 0;
            $count_group = 0;
            foreach($groups as $g){
                $count_group++;
                $sum_debit += $g->mjournaldebit;
                $sum_credit += $g->mjournalcredit;
                $g['mjournalcoaname'] = MCOA::on(Auth::user()->db_name)->where('mcoacode',$g->mjournalcoa)->first()->mcoaname;
                if($count_group != 1){
                  $g['mjournaldate'] = "";
                }
            }

            $data = [
                'date' => $h->mjournaldate,
                'type' => $h->mjournaltranstype,
                'trans' => $h->mjournaltransno,
                'mjournalid' => $h->mjournalid,
                'sum_debit' => $sum_debit,
                'sum_credit' => $sum_credit,
                'transactions' => $groups
            ];


            array_push($journals,$data);
        }

        return response()->json($journals);

    }

    public function group_journal($type){
        $this->type = $type;
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
            $menus = "";

            if($this->type == 'umum'){
                $menus .= '<center><div class="button">
                  <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewincome(\''.$j->mjournalid.'\')"> <font style="">Lihat</font></a>';
                if(Auth::user()->has_role('U_generaljournal')){
                    $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editincome(\''.$j->mjournalid.'\')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
                }
                if(Auth::user()->has_role('D_generaljournal')){
                    $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete(\''.$j->mjournalid.'\')">
                    <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
                }
            } else if($this->type == 'pemasukan'){
                $menus .= '<center><div class="button">
                  <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewincome(\''.$j->mjournalid.'\')"> <font style="">Lihat</font></a>';
                if(Auth::user()->has_role('U_cashbankincome')){
                    $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editincome(\''.$j->mjournalid.'\')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
                }
                if(Auth::user()->has_role('D_cashbankincome')){
                    $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete(\''.$j->mjournalid.'\')">
                    <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
                }
            } else if($this->type == 'pengeluaran'){
                $menus .= '<center><div class="button">
                  <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewincome(\''.$j->mjournalid.'\')"> <font style="">Lihat</font></a>';
                if(Auth::user()->has_role('U_cashbankoutcome')){
                    $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editincome(\''.$j->mjournalid.'\')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
                }
                if(Auth::user()->has_role('D_cashbankoutcome')){
                    $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete(\''.$j->mjournalid.'\')">
                    <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
                }
            } else {
                $menus .= '<center><div class="button">
                  <a class="btn btn-info btn-xs dropdown-toggle fa fa-eye" onclick="viewincome(\''.$j->mjournalid.'\')"> <font style="">Lihat</font></a>';
                if(Auth::user()->has_role('U_cashbanktransfer')){
                    $menus .= '<a class="btn btn-primary btn-xs dropdown-toggle fa fa-pencil" onclick="editincome(\''.$j->mjournalid.'\')"> <font style="font-family: arial;">Ubah &nbsp</font></a>';
                }
                if(Auth::user()->has_role('D_cashbanktransfer')){
                    $menus .= '<a class="btn btn-danger btn-xs dropdown-toggle fa fa-trash" onclick="popupdelete(\''.$j->mjournalid.'\')">
                    <input type="hidden" name="id" value="@{{ task.id }}"> <font style="font-family: arial;">Hapus </font></a>     </div></center>';
                }
            }

          return $menus;
        })->addColumn('no',function($j){
            $this->iteration++;
            return "<span style=\"float:right\">".$this->iteration."</span>";
        })->addColumn('credits',function($j){
            $html_str = "<div>";
            foreach($this->journals as $cjr){
                if($cjr->mjournaldebit != 0){
                    $html_str.="<span style=\"float:left;\">".number_format($cjr->mjournalcredit,$this->decimals,$this->dec_point,$this->thousands_sep)."</span><br><br>";
                } else {
                    $html_str.="<span style=\"margin-left: -80px;\">".number_format($cjr->mjournalcredit,$this->decimals,$this->dec_point,$this->thousands_sep)."</span><br><br>";
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
                    $html_str.="<span style=\"float: left\">".number_format($djr->mjournaldebit,$this->decimals,$this->dec_point,$this->thousands_sep)."</span><br><br>";
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
                    $html_str.="<span style=\"margin-left: -80px;\">".$jr->mjournalcoa." - ".$account->mcoaname." "."</span><br><br>";
                }
            }
            $html_str.="</div>";
            return $html_str;
        })
        ->make(true);
    }
}
