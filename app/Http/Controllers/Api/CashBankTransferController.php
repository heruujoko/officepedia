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

class CashBankTransferController extends Controller
{
    private $t;
    private $new_journal;

    public function show($id){
        $grp = MJournal::on(Auth::user()->db_name)->where('mjournalid',$id)->groupBy('mjournalid')
        ->selectRaw('*,sum(mjournalcredit) as total_credit, sum(mjournaldebit) as total_debit')
        ->first();

        return response()->json($grp);
    }

    public function header($id){
        $grp = MJournal::on(Auth::user()->db_name)->where('mjournalid',$id)->get()->last();
        return response()->json($grp);
    }

    public function details($id){
        $dtls = MJournal::on(Auth::user()->db_name)->where('mjournalid',$id)->where('void',0)->where('mjournaldebit','!=',"")->get();
        return response()->json($dtls);
    }

    public function store(Request $request){
        try{
            DB::connection(Auth::user()->db_name)->beginTransaction();
            $from_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$request->from_account['mcoacode'])->first();
            foreach($request->to_accounts as $to_acc){

                    MJournal::record_journal("","Transfer",$to_acc['mcoacode'],$to_acc['amount'],0,"","","");
                    MJournal::record_journal("","Transfer",$request->from_account['mcoacode'],0,$to_acc['amount'],"","","");

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
            $credit_id = 0;
            $current_details = [];
            $form_details = [];
            $journalID = "";
            foreach ($transactions as $tx) {
                var_dump($tx->id);
                $journal = MJournal::on(Auth::user()->db_name)->where('id',$tx->id)->first();
                $journal->void = 1;
                $journal->save();
                $journalID = $journal->mjournalid;

                $coa_id = MCOA::on(Auth::user()->db_name)->where('mcoacode',$tx->mjournalcoa)->first()->id;
                array_push($current_details,$coa_id);
            }
            var_dump($current_details);
            foreach ($request->to_accounts as $toa) {
                array_push($form_details,$toa['id']);
            }
            foreach($transactions as $t){
                $this->t = $t;
                $journalremark = "";
                $this->new_journal = [];
                // credit side
                if($t->mjournaldebit != ""){
                    var_dump('first');
                    // reset saldo first
                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$t->mjournalcoa)->first();
                    $this->coa = $coa;
                    $coa->update_saldo('-',$t->mjournaldebit);
                    $x_journal = array_map(function($acc){
                        if($acc['id'] == $this->coa->id){
                            array_push($this->new_journal,$acc);
                            return $acc;
                        }
                    },$request->to_accounts);

                    if(sizeof($this->new_journal) > 0){
                        $journal = MJournal::on(Auth::user()->db_name)->where('id',$this->t->id)->first();
                        $journal->mjournalcoa = $this->new_journal[0]['mcoacode'];
                        $journal->mjournaldebit = $this->new_journal[0]['amount'];
                        $journal->mjournaldate = Carbon::parse($request->date);
                        $journal->mjournalremark = $this->new_journal[0]['description'];
                        $journal->void = 0;
                        $journal->save();
                        $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$journal->mjournalcoa)->first();
                        $coa->update_saldo('+',$t->mjournaldebit);

                        // update the credit
                        $credit_id = $this->t->id + 1;
                        $credit_journal = MJournal::on(Auth::user()->db_name)->where('id',$credit_id)->first();
                        $credit_journal->mjournalcredit = $journal->mjournaldebit;
                        $credit_journal->mjournalremark = $journal->mjournalremark;
                        $credit_journal->save();
                    } else {
                        $journal = MJournal::on(Auth::user()->db_name)->where('id',($this->t->id+1))->first();
                        $journal->void =1;
                        $journal->save();
                    }
                }

                // credit side
                if($t->mjournalcredit != ""){
                    var_dump('second');
                    // reset saldo first
                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$t->mjournalcoa)->first();
                    $coa->update_saldo('+',$t->mjournalcredit);
                    $journal = MJournal::on(Auth::user()->db_name)->where('id',$t->id)->first();
                    var_dump($journal->id);
                    $journal->mjournalcoa = $request->from_account['mcoacode'];
                    $journal->mjournaldate = Carbon::parse($request->date);
                    $journal->void = 0;
                    $journal->save();

                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$journal->mjournalcoa)->first();
                    $coa->update_saldo('-',$t->mjournalcredit);
                }
            }

            // voided details
            $void_trans = MJournal::on(Auth::user()->db_name)->where('void',1)->get();
            foreach($void_trans as $v){

                if($v->mjournalcredit != ""){
                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$t->mjournalcoa)->first();
                    $coa->update_saldo('+',$t->mjournalcredit);
                } else {
                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$t->mjournalcoa)->first();
                    $coa->update_saldo('-',$t->mjournaldebit);
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

                    MJournal::record_journal("","Transfer",$to_acc['mcoacode'],$to_acc['amount'],0,"","","");
                    MJournal::record_journal("","Transfer",$request->from_account['mcoacode'],0,$to_acc['amount'],"","","");

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
            dd($e);
            return response()->json('err',400);
        }
    }

    public function destroy($id){
        try{
            DB::connection(Auth::user()->db_name)->beginTransaction();

            // voided details
            $void_trans = MJournal::on(Auth::user()->db_name)->where('void',0)->where('mjournalid',$id)->get();
            foreach($void_trans as $v){
                $v->void = 1;
                $v->save();
                if($v->mjournalcredit != ""){
                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$v->mjournalcoa)->first();
                    $coa->update_saldo('+',$v->mjournalcredit);
                } else {
                    $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$v->mjournalcoa)->first();
                    $coa->update_saldo('-',$v->mjournaldebit);
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
