<?php

namespace App\Helper;

use Auth;
use App\MCOGS;
use App\HPPHistory;
use Carbon\Carbon;
use App\MDInvoice;
use App\MJournal;
use App\MCOA;
use App\MDPurchase;
use App\MGoods;

class IntegrityHelper {

    public static function recalculateTransactionFrom($date){

        // $calculation_date = Carbon::parse($date)->addDays(0);
        // $diff_in_days = Carbon::now()->diffInDays($calculation_date);
        // var_dump('calculating from '.$calculation_date->addDays(1));
        // var_dump('in '.$diff_in_days.' days');
        // $diff_in_days++;

        $affected_history = HPPHistory::on(Auth::user()->db_name)->where('created_at','>',Carbon::parse($date))->where('void',0)->orderBy('created_at','asc')->get();

        var_dump('affecting '.count($affected_history).' histories');

        foreach($affected_history as $af){
            // $loop_date = Carbon::parse($date)->addDays($i);
            // var_dump('loop date '.$loop_date);
            // $mdinvoices = MDInvoice::on(Auth::user()->db_name)->whereDate('mdinvoicedate','=',$loop_date)->get();
            if($af->type == 'sales'){
                var_dump('recalculate sales');
                $mdinvoices = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$af->transno)->get();
                foreach($mdinvoices as $mdi){
                    $hpp_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode','5100.01')->first();
                    $persediaan_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode','1105.01')->first();



                    $hpp_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$mdi->mhinvoiceno)->where('mjournalcoa','5100.01')->first();
                    $persediaan_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$mdi->mhinvoiceno)->where('mjournalcoa','1105.01')->first();
                    $hpp_coa->update_saldo('-',$hpp_journal->mjournaldebit);
                    $persediaan_coa->update_saldo('+',$persediaan_journal->mjournalcredit);

                    $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mdi->mdinvoicegoodsid)->first();

                    $hpp_journal->mjournaldebit = $mdi->mdinvoicegoodsqty * $cogs->mcogslastcogs;
                    var_dump('debit '.$hpp_journal->mjournaldebit);
                    $hpp_journal->save();
                    $persediaan_journal->mjournalcredit = $mdi->mdinvoicegoodsqty * $cogs->mcogslastcogs;
                    var_dump('credit '.$persediaan_journal->mjournalcredit);
                    $persediaan_journal->save();
                    $hpp_coa->update_saldo('+',$hpp_journal->mjournaldebit);
                    $persediaan_coa->update_saldo('-',$persediaan_journal->mjournalcredit);
                    $af->hpphistorycogs = $cogs->mcogslastcogs;
                    $af->save();
                }

            } else {
                var_dump('recalculate purchase');
                $mdpurchase = MDPurchase::on(Auth::user()->db_name)->where('mhpurchaseno',$af->transno)->get();
                foreach($mdpurchase as $mdp){
                    $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$mdp->mdpurchasegoodsid)->first();
                    $mgoods->mgoodsstock += $mdp->mdpurchasegoodsqty;
                    $mgoods->save();
                    $mdp->cogs_ref = IntegrityHelper::updateCOGS($mgoods,$mdp,$mdp->mdpurchasegoodsqty,$af,$remarks = "Revisi Pembelian Turunan");
                    $mdp->save();
                }
            }
        }
    }

    /*
     *  on create purchase
     */
    public static function calculateCOGS($mgoods,$mdpurchasegoodsgrossamount,$buy_amount,$purchaseno,$remarks = "Pembelian"){
        $lastcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->where('type','purchase')->get()->last();
        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
        $lastcogsvalue = 0;
        $lastqtysvalue = 0;
        $cogs_num = 0;
        if($cogs == null){
            $cogs = new MCOGS;
            $cogs->setConnection(Auth::user()->db_name);
            $cogs->mcogsgoodscode = $mgoods->mgoodscode;
            $cogs->mcogsgoodsname = $mgoods->mgoodsname;
            $cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
            $cogs->mcogslastcogs = $mdpurchasegoodsgrossamount / $mgoods->mgoodsstock;
            $cogs->mcogsremarks = $remarks;
            $cogs->save();
            $cogs_num = $cogs->mcogslastcogs;
        } else {
            var_dump($mgoods->mgoodsstock.' - '.$buy_amount);
            $last_stock = $mgoods->mgoodsstock - $buy_amount;
            $histories =  HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->get();
            $last_history = $histories->last();
            $lastqtysvalue = $last_history->hpphistoryqty;
            $lastcogsvalue = $last_history->hpphistorycogs;
            var_dump('last stock '.$last_stock);
            var_dump('last stock '.$lastcogsvalue);
            var_dump('mdpurchasegoodsgrossamount '.$mdpurchasegoodsgrossamount);
            var_dump('all stock '.$mgoods->mgoodsstock);
            $cogs_num = (($last_stock * $lastcogsvalue) + $mdpurchasegoodsgrossamount ) / $mgoods->mgoodsstock;

            $cogs->mcogslastcogs = $cogs_num;
            $cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
            $cogs->save();
        }

        // save cogs log
        $h = new HPPHistory;
        $h->setConnection(Auth::user()->db_name);
        $h->hpphistorygoodsid = $mgoods->mgoodscode;
        $h->hpphistorypurchase = $mdpurchasegoodsgrossamount;
        $h->hpphistoryqty = $mgoods->mgoodsstock;
        $h->hpphistorycogs = $cogs_num;
        $h->lastcogs = $lastcogsvalue;
        $h->lastqty = $lastqtysvalue;
        $h->type = 'purchase';
        $h->usage = $buy_amount;
        $h->transno = $purchaseno;
        $h->buyprice = ($mdpurchasegoodsgrossamount / $buy_amount);
        $h->hpphistoryremarks = $remarks;
        $h->save();

        return $h->id;

    }

    /*
     *  on update purchase
     */
    public static function updateCOGS($mgoods,$mdpurchase,$buy_amount,$edited_history,$remarks = "Revisi Pembelian"){
        $lastcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->where('type','purchase')->where('created_at','<',Carbon::parse($edited_history->created_at))->orderBy('created_at','asc')->get()->last();
        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
        $cogs_num = 0;

        $lastcogsvalue = 0;
        $lastqtyvalue = 0;
        if($lastcogs != null){
            $lastcogsvalue = $lastcogs->hpphistorycogs;
            $lastqtyvalue = $lastcogs->hpphistoryqty;

            var_dump('lastcogsvalue '.$lastcogsvalue);
            var_dump('lastqtyvalue '.$lastqtyvalue);
            var_dump('goods_stock '.$mgoods->mgoodsstock);

            $last_stock = $lastqtyvalue;
            var_dump('last_stock '.$last_stock);
            $cogs->mcogsgoodstotalqty -= $lastcogs->hpphistoryqty;
            var_dump('(('.$last_stock.' * '.$lastcogsvalue.' + '.$mdpurchase->mdpurchasegoodsgrossamount.' / '.$mgoods->mgoodsstock.' ))');
            $cogs_num = (($last_stock * $lastcogsvalue) + $mdpurchase->mdpurchasegoodsgrossamount ) / $mgoods->mgoodsstock;

            var_dump('cogs_num '.$cogs_num);
            // $lastcogsvalue = $cogs->mcogslastcogs;
            $cogs->mcogslastcogs = $cogs_num;
            $cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
            $cogs->save();
        } else {
            var_dump('is first history');
            $cogs_num = $mdpurchase->mdpurchasegoodsgrossamount / $mdpurchase->mdpurchasegoodsqty;

            var_dump('cogs_num '.$cogs_num);
            // $lastcogsvalue = $cogs->mcogslastcogs;
            $cogs->mcogslastcogs = $cogs_num;
            $cogs->mcogsgoodstotalqty = $mdpurchase->mdpurchasegoodsqty;
            $cogs->save();
            $mgoods->mgoodsstock = $mdpurchase->mdpurchasegoodsqty;
            $mgoods->save();
        }



        // void edited history
        // $lastcogs->void = 1;
        $edited_history->void = 1;
        $edited_history->save();

        // save cogs log
        $h = new HPPHistory;
        $h->setConnection(Auth::user()->db_name);
        $h->hpphistorygoodsid = $mgoods->mgoodscode;
        $h->hpphistorypurchase = $mdpurchase->mdpurchasegoodsgrossamount;
        $h->hpphistoryqty = $mgoods->mgoodsstock;
        $h->hpphistorycogs = $cogs_num;
        $h->lastcogs = $lastcogsvalue;
        $h->type = 'purchase';
        $h->usage = $mdpurchase->mdpurchasegoodsqty;
        $h->lastqty = $lastqtyvalue;
        $h->transno = $mdpurchase->mhpurchaseno;
        $h->buyprice = ($mdpurchase->mdpurchasegoodsgrossamount / $mdpurchase->mdpurchasegoodsqty);
        $h->hpphistoryremarks = $remarks;
        $h->save();

        $h->created_at = $edited_history->created_at;
        $h->save();

        return $h->id;

    }

    /*
     *  on delete purchase
     */
    public static function deleteCOGS($mgoods,$mdpurchasegoodsgrossamount,$remarks = ""){
        $lastcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->where('type','purchase')->get()->last();
        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
        $cogs_num = 0;

            // $cogs->mcogslastcogs -= $lastcogs->hpphistorycogs;
            $cogs->mcogsgoodstotalqty = $lastcogs->lastqty;
            $cogs->mcogslastcogs = $lastcogs->lastcogs;
            $cogs->save();

        $lastcogs->void = 1;
        $lastcogs->save();
        // save cogs log
        // $h = new HPPHistory;
        // $h->setConnection(Auth::user()->db_name);
        // $h->hpphistorygoodsid = $mgoods->mgoodscode;
        // $h->hpphistorypurchase = 0;
        // $h->hpphistoryqty = $mgoods->mgoodsstock;
        // $h->hpphistorycogs = $cogs_num;
        // $h->hpphistoryremarks = $remarks;
        // $h->save();
        //
        // return $h->id;

    }


    /*
     *  on delete sales
     */
    public static function restoreCOGS($mgoods,$invoiceno,$usage,$remarks = ""){

        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
        $history = HPPHistory::on(Auth::user()->db_name)->where('transno',$invoiceno)->first();
        $history->void = 1;
        $history->save();
        $cogs->mcogsgoodstotalqty = $history->prev()->hpphistoryqty;
        $cogs->mcogslastcogs = $history->prev()->hpphistorycogs;
        $cogs->save();

        $mgoods->mgoodsstock = $cogs->mcogsgoodstotalqty;
        $mgoods->save();

        var_dump('STOCK dalam helper '.$mgoods->mgoodsstock);
        $start_state = $history->prev();

        $affected_transaction = HPPHistory::on(Auth::user()->db_name)->where('id','>', $start_state->id)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->where('transno','!=',$invoiceno)->get();
        $count = 0;
        $first_purcahse_since = true;
        foreach($affected_transaction as $tr){
            $count++;
            if($tr->type == 'purchase'){
                if($first_purcahse_since){
                    $tr->hpphistoryqty += $usage;
                    $tr->lastqty += $usage;
                    $tr->hpphistorypurchase = ($tr->hpphistoryqty * $tr->buyprice);
                    $first_purcahse_since = false;
                }

                $hpp = (($mgoods->mgoodsstock * $tr->lastcogs) + ($tr->usage * $tr->buyprice)) / ($mgoods->mgoodsstock + $tr->usage);
                var_dump('hpp '.$tr->id.' - '.$tr->transno.' = '.$hpp);
                $tr->hpphistorycogs = $hpp;
                $tr->save();

                $mgoods->mgoodsstock += $tr->usage;
                $mgoods->save();
                $cogs->mcogslastcogs = $hpp;
                $cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                $cogs->save();
                var_dump('stock '.$mgoods->mgoodsstock);
            } else if($tr->type == 'sales') {
                var_dump('sales '.$tr->id.' - '.$tr->transno);
                $mgoods->mgoodsstock -= $tr->usage;
                $mgoods->save();
                $tr->hpphistorycogs = $cogs->mcogslastcogs;
                $tr->lastcogs = $cogs->mcogslastcogs;
                $tr->lastqty = $tr->prev()->hpphistoryqty;
                $tr->hpphistoryqty = $mgoods->mgoodsstock;
                $tr->save();
                var_dump('stock '.$mgoods->mgoodsstock);
            } else {

            }
        }
    }
}
