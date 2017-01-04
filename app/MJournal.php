<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class MJournal extends Model
{
    protected $table = 'mjournal';

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
