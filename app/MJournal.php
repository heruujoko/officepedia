<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;
use App\MBRANCH;

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

    // TODO more safer way to add prefix ?
    public static function add_prefix(){
        $journals = MJournal::on(Auth::user()->db_name)->where('mjournalid',"")->get();
        MJournal::update_prefix_status();
        foreach($journals as $j){
            $j->mjournalid = MJournal::get_prefix();
            $j->save();
        }
    }

    public static function record_journal($transaction,$type,$coa,$debit,$credit,$remark,$md_ap,$md_ar,$journal_date,$department = ""){

        $branch_code = Auth::user()->defaultbranch;
        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',$branch_code)->first();

        $journal = new MJournal;
        $journal->setConnection(Auth::user()->db_name);
        $journal->mjournaldate = Carbon::parse($journal_date);
        $journal->mjournaltransno = $transaction;
        $journal->mjournaltranstype = $type;
        $journal->mjournalcoa = $coa;
        $journal->mjournaldebit = $debit;
        $journal->mjournalcredit = $credit;
        $journal->mjournalremark = $remark;
        $journal->mdpayap_ref = $md_ap;
        $journal->mdpayar_ref = $md_ar;
        $journal->paymenttype = "system";
        $journal->mjournaldepartmentid = $department;
        $journal->mjournalbranchcode = $branch->mbranchcode;
        $journal->mjournalbranchname = $branch->mbranchname;
        $journal->save();
    }

    public static function record_journal_cash($transaction,$type,$coa,$debit,$credit,$remark,$md_ap,$md_ar,$journal_date){

        $branch_code = Auth::user()->defaultbranch;
        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',$branch_code)->first();

        $journal = new MJournal;
        $journal->setConnection(Auth::user()->db_name);
        $journal->mjournaldate = Carbon::parse($journal_date);
        $journal->mjournaltransno = $transaction;
        $journal->mjournaltranstype = $type;
        $journal->mjournalcoa = $coa;
        $journal->mjournaldebit = $debit;
        $journal->mjournalcredit = $credit;
        $journal->mjournalremark = $remark;
        $journal->mdpayap_ref = $md_ap;
        $journal->mdpayar_ref = $md_ar;
        $journal->paymenttype = "cash";
        $journal->mjournalbranchcode = $branch->mbranchcode;
        $journal->mjournalbranchname = $branch->mbranchname;
        $journal->save();
    }

    public static function record_journal_bank($transaction,$type,$coa,$debit,$credit,$remark,$md_ap,$md_ar,$journal_date){

        $branch_code = Auth::user()->defaultbranch;
        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',$branch_code)->first();

        $journal = new MJournal;
        $journal->setConnection(Auth::user()->db_name);
        $journal->mjournaldate = Carbon::parse($journal_date);
        $journal->mjournaltransno = $transaction;
        $journal->mjournaltranstype = $type;
        $journal->mjournalcoa = $coa;
        $journal->mjournaldebit = $debit;
        $journal->mjournalcredit = $credit;
        $journal->mjournalremark = $remark;
        $journal->mdpayap_ref = $md_ap;
        $journal->mdpayar_ref = $md_ar;
        $journal->paymenttype = "bank";
        $journal->mjournalbranchcode = $branch->mbranchcode;
        $journal->mjournalbranchname = $branch->mbranchname;
        $journal->save();
    }
}
