<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class MJournal extends Model
{
    protected $table = 'mjournal';

    public static function update_prefix_status(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixjournalcount = $conf->msysprefixjournalcount+1;
      $conf->msysprefixjournallastcount = $conf->get_last_count_format($conf->msysprefixjournalcount);
      $conf->save();
    }

    public static function get_prefix(){
        $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        return $conf->msysprefixjournal.$conf->msysprefixjournallastcount;
    }

    public static function add_prefix(){
        $journals = MJournal::on(Auth::user()->db_name)->where('mjournalid',"")->get();
        MJournal::update_prefix_status();
        foreach($journals as $j){
            $j->mjournalid = MJournal::get_prefix();
            $j->save();
        }
    }

    public static function record_journal($transaction,$type,$coa,$debit,$credit,$remark,$md_ap,$md_ar){
        $journal = new MJournal;
        $journal->setConnection(Auth::user()->db_name);
        $journal->mjournaldate = Carbon::now();
        $journal->mjournaltransno = $transaction;
        $journal->mjournaltranstype = $type;
        $journal->mjournalcoa = $coa;
        $journal->mjournaldebit = $debit;
        $journal->mjournalcredit = $credit;
        $journal->mjournalremark = $remark;
        $journal->mdpayap_ref = $md_ap;
        $journal->mdpayar_ref = $md_ar;
        $journal->save();
    }
}
