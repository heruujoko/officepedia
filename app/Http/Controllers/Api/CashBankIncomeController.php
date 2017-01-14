<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Exception;
use Auth;
use App\MJournal;
use App\MCOA;
use DB;
use Carbon\Carbon;

class CashBankIncomeController extends Controller
{

    private $t;
    private $new_journal;

    public function show($id){
        $grp = MJournal::on(Auth::user()->db_name)->where('mjournalid',$id)->groupBy('mjournalid')
        ->selectRaw('*,sum(mjournalcredit) as total_credit, sum(mjournaldebit) as total_debit')
        ->first();

        return response()->json($grp);
    }

    public function details($id){
        $dtls = MJournal::on(Auth::user()->db_name)->where('mjournalid',$id)->where('void',0)->where('mjournalcredit','!=',"")->get();
        return response()->json($dtls);
    }

    public function store(Request $request){
        try{
            DB::connection(Auth::user()->db_name)->beginTransaction();
            $from_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$request->from_account['mcoacode'])->first();
            foreach($request->to_accounts as $to_acc){
                    MJournal::record_journal("","Pemasukan",$request->from_account['mcoacode'],$to_acc['amount'],0,"","","");
                    MJournal::record_journal("","Pemasukan",$to_acc['mcoacode'],0,$to_acc['amount'],"","","");

                    $to_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$to_acc['mcoacode'])->first();

                    $from_coa->update_saldo('-',$to_acc['amount']);
                    $to_coa->update_saldo('+',$to_acc['amount']);
            }
            MJournal::add_prefix();

            DB::connection(Auth::user()->db_name)->commit();
            return response()->json('ok');
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return response()->json('err',400);
        }
    }

    public function update($id,Request $request){
        try{
            DB::connection(Auth::user()->db_name)->beginTransaction();
            $transactions = MJournal::on(Auth::user()->db_name)->where('mjournalid',$id)->where('void',0)->orderBy('id','asc')->get();
            $debit_id = 0;
            $current_details = [];
            $form_details = [];
            $journalID = "";
            foreach ($transactions as $tx) {
                var_dump($tx->id);
                $journal = MJournal::on(Auth::user()->db_name)->where('id',$tx->id)->first();
                $journal->void = 1;
                $journal->save();
                $journalID = $journal->mjournalid;
                array_push($current_details,$tx->id);
            }
            foreach ($request->to_accounts as $toa) {
                array_push($form_details,$toa['id']);
            }
            foreach($transactions as $t){
                $this->t = $t;
                $journalremark = "";
                $this->new_journal = [];
                // credit side
                if($t->mjournalcredit != ""){
                    var_dump('second');
                    // reset saldo first
                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$t->mjournalcoa)->first();
                    $coa->update_saldo('-',$t->mjournalcredit);
                    $x_journal = array_map(function($acc){

                        if($acc['id'] == $this->t->id){
                            array_push($this->new_journal,$acc);
                            return $acc;
                        }
                    },$request->to_accounts);

                    if(sizeof($this->new_journal) > 0){
                        $journal = MJournal::on(Auth::user()->db_name)->where('id',$this->t->id)->first();
                        $journal->mjournalcoa = $this->new_journal[0]['mcoacode'];
                        $journal->mjournalcredit = $this->new_journal[0]['amount'];
                        $journal->mjournaldate = Carbon::parse($request->date);
                        $journal->mjournalremark = $this->new_journal[0]['description'];
                        $journal->void = 0;
                        $journal->save();
                        $credit_id = $journal->id;
                        $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$journal->mjournalcoa)->first();
                        $coa->update_saldo('+',$t->mjournalcredit);

                        // update the debit
                        var_dump($debit_id);
                        $debit_journal = MJournal::on(Auth::user()->db_name)->where('id',$debit_id)->first();
                        $debit_journal->mjournaldebit = $journal->mjournalcredit;
                        $debit_journal->mjournalremark = $journal->mjournalremark;
                        $debit_journal->save();
                    } else {
                        $journal = MJournal::on(Auth::user()->db_name)->where('id',($this->t->id-1))->first();
                        $journal->void =1;
                        $journal->save();
                    }
                }

                // debit side
                if($t->mjournaldebit != ""){
                    var_dump('first');
                    // reset saldo first
                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$t->mjournalcoa)->first();
                    $coa->update_saldo('+',$t->mjournaldebit);
                    $journal = MJournal::on(Auth::user()->db_name)->where('id',$t->id)->first();
                    var_dump($journal->id);
                    $journal->mjournalcoa = $request->from_account['mcoacode'];
                    $journal->mjournaldate = Carbon::parse($request->date);
                    $journal->void = 0;
                    $journal->save();
                    $debit_id = $journal->id;

                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$journal->mjournalcoa)->first();
                    $coa->update_saldo('-',$t->mjournaldebit);
                }
            }

            // voided details
            $void_trans = MJournal::on(Auth::user()->db_name)->where('void',1)->get();
            foreach($void_trans as $v){

                if($v->mjournalcredit != ""){
                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$t->mjournalcoa)->first();
                    $coa->update_saldo('-',$t->mjournalcredit);
                } else {
                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$t->mjournalcoa)->first();
                    $coa->update_saldo('+',$t->mjournaldebit);
                }
            }

            // new details
            foreach($form_details as $form_detail_id){
                $from_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$request->from_account['mcoacode'])->first();
                if(!in_array($form_detail_id,$current_details)){

                    $to_acc = [];

                    foreach($request->to_accounts as $ta){
                        if($ta['id'] == $form_detail_id){
                            $to_acc = $ta;
                        }
                    }

                    MJournal::record_journal("","Pemasukan",$request->from_account['mcoacode'],$to_acc['amount'],0,"","","");
                    MJournal::record_journal("","Pemasukan",$to_acc['mcoacode'],0,$to_acc['amount'],"","","");

                    $to_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$to_acc['mcoacode'])->first();

                    $from_coa->update_saldo('-',$to_acc['amount']);
                    $to_coa->update_saldo('+',$to_acc['amount']);

                    // set journalid
                    $unids = MJournal::on(Auth::user()->db_name)->where('mjournalid',"")->get();

                    foreach ($unids as $uid) {
                        $uid->mjournalid = $journalID;
                        $uid->save();
                    }
                }
            }

            DB::connection(Auth::user()->db_name)->commit();
            return response()->json('ok');
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return response()->json('err',400);
        }
    }

    public function destroy($id){
        try{
            DB::connection(Auth::user()->db_name)->beginTransaction();
            $journals = MJournal::on(Auth::user()->db_name)->where('mjournalid',$id)->get();
            foreach ($journals as $j) {
                $j->void = 1;
                $j->save();
                $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$j->mjournalcoa)->first();
                if($j->mjournaldebit != ""){
                    $coa->update_saldo('+',$j->mjournaldebit);
                } else {
                    $coa->update_saldo('-',$j->mjournalcredit);
                }
            }
            DB::connection(Auth::user()->db_name)->commit();
            return response()->json('ok');
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return response()->json('err',400);
        }
    }
}
