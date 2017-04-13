<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\MJournal;
use Carbon\Carbon;
use App\MCOA;

class GeneralJournalController extends Controller
{
    public function store(Request $request){
       try{
           DB::connection(Auth::user()->db_name)->beginTransaction();

           $branch_code = Auth::user()->defaultbranch;
           $branch = MBRANCH::on(Auth::user()->db_name)->where('id',$branch_code)->first();

           foreach($request->items as $item){
//               MJournal::record_journal("","Jurnal Umum",$item['mcoacode'],$item['debit'],$item['credit'],"","","");
               $journal = new MJournal;
               $journal->setConnection(Auth::user()->db_name);
               $journal->mjournaldate = Carbon::parse($request->date);
               $journal->mjournaltransno = "";
               $journal->mjournaltranstype = "Jurnal Umum";
               $journal->mjournalcoa = $item['mcoacode'];
               $journal->mjournaldebit = $item['debit'];
               $journal->mjournalcredit = $item['credit'];
               $journal->mjournalremark = "";
               $journal->mdpayap_ref = "";
               $journal->mdpayar_ref = "";
               $journal->general_journal_detail_id = $item['general_journal_detail_id'];
               $journal->mjournalbranchcode = $branch->mbranchcode;
               $journal->mjournalbranchname = $branch->mbranchname;
               $journal->save();
               // update saldo
               $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$journal->mjournalcoa)->first();
               if($journal->mjournaldebit != 0){
                   $coa->update_saldo("+",$journal->mjournaldebit);
               } else {
                   $coa->update_saldo("-",$journal->mjournalcredit);
               }

           }
           MJournal::add_prefix();
           DB::connection(Auth::user()->db_name)->commit();
           return response()->json("ok");
       } catch( \Exception $e){
           DB::connection(Auth::user()->db_name)->rollBack();
           dd($e);
           return response()->json("err",400);
       }
    }

    public function show($id){
        $j = MJournal::on(Auth::user()->db_name)->where('mjournalid',$id)->where('void',0)->get();
        return response()->json($j);
    }

    public function update(Request $request,$id){
        try{
            DB::connection(Auth::user()->db_name)->beginTransaction();

            $journals = MJournal::on(Auth::user()->db_name)->where('mjournalid',$id)->where('void',0)->get();
            $form_ids = [];
            $db_ids = [];
            foreach($journals as $j ){
                $j->void = 1;
                $j->save();
                array_push($db_ids,$j->general_journal_detail_id);
            }

            foreach($request->items as $item){
                array_push($form_ids,$item['general_journal_detail_id']);
                foreach($journals as $j){

                    if($item['general_journal_detail_id'] == $j->general_journal_detail_id){

                        $coa = MCOA::on(Auth::user()->db_nam)->where('mcoacode',$j->mjournalcoa)->first();
                        if($j->mjournaldebit != 0){
                            $coa->update_saldo("-",$j->mjournaldebit);
                        } else {
                            $coa->update_saldo("+",$j->mjournalcredit);
                        }

                        $j->mjournaldate = Carbon::parse($request->date);
                        $j->mjournalcoa = $item['mcoacode'];
                        $j->mjournaldebit = $item['debit'];
                        $j->mjournalcredit = $item['credit'];
                        $j->void = 0;
                        $j->save();

                        $coa = MCOA::on(Auth::user()->db_nam)->where('mcoacode',$j->mjournalcoa)->first();
                        if($j->mjournaldebit != 0){
                            $coa->update_saldo("+",$j->mjournaldebit);
                        } else {
                            $coa->update_saldo("-",$j->mjournalcredit);
                        }
                    }
                }
            }

            // voided details
            $voided_details = MJournal::on(Auth::user()->db_name)->where('mjournalid',$id)->where('void',1)->get();
            var_dump($voided_details);
            foreach ($voided_details as $v){
                $coa = MCOA::on(Auth::user()->db_nam)->where('mcoacode',$v->mjournalcoa)->first();
                if($v->mjournaldebit != 0){
                    $coa->update_saldo("-",$v->mjournaldebit);
                } else {
                    $coa->update_saldo("+",$v->mjournalcredit);
                }
            }

            // new details
            $new_details = array_diff($form_ids,$db_ids);

            foreach($new_details as $n){
                foreach($request->items as $item ){
                    if($item['general_journal_detail_id'] == $n){
                        $journal = new MJournal;
                        $journal->setConnection(Auth::user()->db_name);
                        $journal->mjournaldate = Carbon::parse($request->date);
                        $journal->mjournaltransno = $id;
                        $journal->mjournalid = $id;
                        $journal->mjournaltranstype = "Jurnal Umum";
                        $journal->mjournalcoa = $item['mcoacode'];
                        $journal->mjournaldebit = $item['debit'];
                        $journal->mjournalcredit = $item['credit'];
                        $journal->mjournalremark = "";
                        $journal->mdpayap_ref = "";
                        $journal->mdpayar_ref = "";
                        $journal->general_journal_detail_id = $item['general_journal_detail_id'];
                        $journal->save();
                        // update saldo
                        $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$journal->mjournalcoa)->first();
                        if($journal->mjournaldebit != 0){
                            $coa->update_saldo("+",$journal->mjournaldebit);
                        } else {
                            $coa->update_saldo("-",$journal->mjournalcredit);
                        }
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
            $voided_details = MJournal::on(Auth::user()->db_name)->where('mjournalid',$id)->get();
            var_dump($voided_details);
            foreach ($voided_details as $v){
                $v->void = 1;
                $v->save();
                $coa = MCOA::on(Auth::user()->db_nam)->where('mcoacode',$v->mjournalcoa)->first();
                if($v->mjournaldebit != 0){
                    $coa->update_saldo("-",$v->mjournaldebit);
                } else {
                    $coa->update_saldo("+",$v->mjournalcredit);
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
}
