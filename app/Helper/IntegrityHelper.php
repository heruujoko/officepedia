<?php

namespace App\Helper;

use Auth;
use App\MCOGS;
use App\HPPHistory;
use Carbon\Carbon;
use App\MDInvoice;
use App\MJournal;

class IntegrityHelper {

    public static function recalculateTransactionFrom($date){

        $calculation_date = Carbon::parse($date)->addDays(0);
        var_dump('calculating from '.$date);
        $diff_in_days = Carbon::now()->diffInDays($calculation_date);
        $diff_in_days++;

        for($i=0;$i<$diff_in_days;$i++){
            $loop_date = Carbon::parse($date)->addDays($i);
            $mdinvoices = MDInvoice::on(Auth::user()->db_name)->whereDate('mdinvoicedate','=',$loop_date)->get();
            foreach($mdinvoices as $mdi){
                $hpp_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$mdi->mhinvoiceno)->where('mjournalcoa','5100.01')->first();
                $persediaan_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$mdi->mhinvoiceno)->where('mjournalcoa','1105.01')->first();
                $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mdi->mdinvoicegoodsid)->first();

                $hpp_journal->mjournaldebit = $mdi->mdinvoicegoodsqty * $cogs->mcogslastcogs;
                $hpp_journal->save();
                $persediaan_journal->mjournalcredit = $mdi->mdinvoicegoodsqty * $cogs->mcogslastcogs;
                $persediaan_journal->save();
            }
        }

    }

    public static function updateCOGS($mgoods,$mdpurchasegoodsgrossamount,$remarks = ""){
        $lastcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->get()->last();
        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
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
            // $cogs->mcogslastcogs -= $lastcogs->hpphistorycogs;
            $cogs->mcogsgoodstotalqty -= $lastcogs->hpphistoryqty;

            $last_stock = $mgoods->mgoodstock - $lastcogs->hpphistoryqty;

            $cogs_num = (($last_stock * $cogs->mcogslastcogs) + $mdpurchasegoodsgrossamount ) / $mgoods->mgoodsstock;

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
        $h->hpphistoryremarks = $remarks;
        $h->save();

        return $h->id;

    }

    public static function calculateCOGS($mgoods,$mdpurchasegoodsgrossamount,$remarks = ""){
        $lastcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->get()->last();
        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
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
            // $last_stock = $mgoods->mgoodstock - $lastcogs->hpphistoryqty;
            $sum_buy_price = 0;
            $histories =  HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->get();

            foreach ($histories as $h) {
                $sum_buy_price += $h->hpphistorypurchase;
            }

            $cogs_num = ($sum_buy_price + $mdpurchasegoodsgrossamount ) / $mgoods->mgoodsstock;

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
        $h->hpphistoryremarks = $remarks;
        $h->save();

        return $h->id;

    }

    public static function deleteCOGS($mgoods,$mdpurchasegoodsgrossamount,$remarks = ""){
        $lastcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->get()->last();
        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
        $cogs_num = 0;

            // $cogs->mcogslastcogs -= $lastcogs->hpphistorycogs;
            $cogs->mcogsgoodstotalqty -= $lastcogs->hpphistoryqty;

            $last_stock = $mgoods->mgoodstock - $lastcogs->hpphistoryqty;
            if($mgoods->mgoodsstock != 0 ){
                $cogs_num = (($last_stock * $cogs->mcogslastcogs) - $mdpurchasegoodsgrossamount ) / $mgoods->mgoodsstock;
            }

            $cogs->mcogslastcogs = $cogs_num;
            $cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
            $cogs->save();


        // save cogs log
        $h = new HPPHistory;
        $h->setConnection(Auth::user()->db_name);
        $h->hpphistorygoodsid = $mgoods->mgoodscode;
        $h->hpphistorypurchase = 0;
        $h->hpphistoryqty = $mgoods->mgoodsstock;
        $h->hpphistorycogs = $cogs_num;
        $h->hpphistoryremarks = $remarks;
        $h->save();

        return $h->id;

    }

}
