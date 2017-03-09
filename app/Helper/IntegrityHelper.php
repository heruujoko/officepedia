<?php

namespace App\Helper;

use Auth;
use App\MCOGS;
use App\HPPHistory;
use Carbon\Carbon;
use App\MDInvoice;
use App\MJournal;
use App\MCOA;

class IntegrityHelper {

    public static function recalculateTransactionFrom($date){

        $calculation_date = Carbon::parse($date)->addDays(0);
        $diff_in_days = Carbon::now()->diffInDays($calculation_date);
        var_dump('calculating from '.$calculation_date->addDays(1));
        var_dump('in '.$diff_in_days.' days');
        $diff_in_days++;

        for($i=1;$i<=$diff_in_days;$i++){
            $loop_date = Carbon::parse($date)->addDays($i);
            var_dump('loop date '.$loop_date);
            $mdinvoices = MDInvoice::on(Auth::user()->db_name)->whereDate('mdinvoicedate','=',$loop_date)->get();
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
            }
        }

    }

    public static function updateCOGS($mgoods,$mdpurchasegoodsgrossamount,$buy_amount,$remarks = ""){
        $lastcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->where('type','purchase')->get()->last();
        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
        $cogs_num = 0;
        $lastcogsvalue = $lastcogs->lastcogs;
        $lastqtyvalue = $lastcogs->lastqty;

        var_dump('lastcogsvalue '.$lastcogsvalue);
        var_dump('lastqtyvalue '.$lastqtyvalue);

        $last_stock = $lastcogs->lastqty;
        var_dump('last_stock '.$last_stock);
        $cogs->mcogsgoodstotalqty -= $lastcogs->hpphistoryqty;
        var_dump('(('.$last_stock.' * '.$lastcogsvalue.' + '.$mdpurchasegoodsgrossamount.' / '.$mgoods->mgoodsstock.' ))');
        $cogs_num = (($last_stock * $lastcogsvalue) + $mdpurchasegoodsgrossamount ) / $mgoods->mgoodsstock;
        var_dump('cogs_num '.$cogs_num);
        // $lastcogsvalue = $cogs->mcogslastcogs;
        $cogs->mcogslastcogs = $cogs_num;
        $cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
        $cogs->save();

        // void edited history
        $lastcogs->void = 1;
        $lastcogs->save();

        // save cogs log
        $h = new HPPHistory;
        $h->setConnection(Auth::user()->db_name);
        $h->hpphistorygoodsid = $mgoods->mgoodscode;
        $h->hpphistorypurchase = $mdpurchasegoodsgrossamount;
        $h->hpphistoryqty = $mgoods->mgoodsstock;
        $h->hpphistorycogs = $cogs_num;
        $h->lastcogs = $lastcogsvalue;
        $h->type = 'purchase';
        $h->usage = $buy_amount;
        $h->lastqty = $lastqtyvalue;
        $h->buyprice = ($mdpurchasegoodsgrossamount / $buy_amount);
        $h->hpphistoryremarks = 'Revisi Pembelian';
        $h->save();

        return $h->id;

    }

    public static function calculateCOGS($mgoods,$mdpurchasegoodsgrossamount,$buy_amount,$remarks = ""){
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
        $h->buyprice = ($mdpurchasegoodsgrossamount / $buy_amount);
        $h->hpphistoryremarks = 'Pembelian';
        $h->save();

        return $h->id;

    }

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

}
