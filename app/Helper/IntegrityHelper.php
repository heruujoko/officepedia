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
use App\MGoodsWarehouse;
use App\MBRANCH;
use App\MWarehouse;

class IntegrityHelper {

    public static function recalculateSalesTransactionFrom($date,$edited_history,$mdinvoice){
      $affected_history = HPPHistory::on(Auth::user()->db_name)->where('created_at','>',Carbon::parse($date))->where('void',0)->where('hpphistorygoodsid',$edited_history->hpphistorygoodsid)->orderBy('created_at','asc')->get();
      // var_dump('affecting '.count($affected_history).' histories');

        $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$edited_history->hpphistorygoodsid)->first();
        // var_dump('goods stock awal = '.$mgoods->mgoodsstock);
        $mgoods->mgoodsstock = $edited_history->lastqty - $mdinvoice->mdinvoicegoodsqty;
        $mgoods->save();
        // var_dump('goods nya jadi '.$mgoods->mgoodsstock);
        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();
      // save cogs log
      $h = new HPPHistory;
      $h->setConnection(Auth::user()->db_name);
      $h->hpphistorygoodsid = $mgoods->mgoodscode;
      $h->hpphistorypurchase = 0;
      $h->hpphistoryqty = $mgoods->mgoodsstock;
      $h->hpphistorycogs = $edited_history->hpphistorycogs;
      $h->lastcogs = $edited_history->lastcogs;
      $h->lastqty = $edited_history->lastqty;
      $h->type = 'sales';
      $h->usage = $mdinvoice->mdinvoicegoodsqty;
      $h->transno = $mdinvoice->mhinvoiceno;
      $h->buyprice = 0;
      $h->hpphistoryremarks = "Revisi Penjualan";
      $h->branchid = $branch->mbranchcode;
      $h->save();
      $h->created_at = $edited_history->created_at;
      $h->save();

      $edited_history->void = 1;
      $edited_history->save();

      foreach($affected_history as $af){
          // var_dump($af->id);
          // $loop_date = Carbon::parse($date)->addDays($i);
          // var_dump('loop date '.$loop_date);
          // $mdinvoices = MDInvoice::on(Auth::user()->db_name)->whereDate('mdinvoicedate','=',$loop_date)->get();
          if($af->type == 'sales'){
              // var_dump('recalculate sales');
              $mdinvoices = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$af->transno)->get();
              foreach($mdinvoices as $mdi){
                  $hpp_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode','5100.01')->first();
                  $persediaan_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode','1105.01')->first();

                  $hpp_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$mdi->mhinvoiceno)->where('mjournalcoa','5100.01')->first();
                  $persediaan_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$mdi->mhinvoiceno)->where('mjournalcoa','1105.01')->first();
                  $hpp_coa->update_saldo('-',$hpp_journal->mjournaldebit);
                  $persediaan_coa->update_saldo('+',$persediaan_journal->mjournalcredit);

                  $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mdi->mdinvoicegoodsid)->where('branchid',$branch->mbranchcode)->first();

                  $hpp_journal->mjournaldebit = $mdi->mdinvoicegoodsqty * $cogs->mcogslastcogs;
                  // var_dump('debit '.$hpp_journal->mjournaldebit);
                  $hpp_journal->save();
                  $persediaan_journal->mjournalcredit = $mdi->mdinvoicegoodsqty * $cogs->mcogslastcogs;
                  // var_dump('credit '.$persediaan_journal->mjournalcredit);
                  $persediaan_journal->save();
                  $hpp_coa->update_saldo('+',$hpp_journal->mjournaldebit);
                  $persediaan_coa->update_saldo('-',$persediaan_journal->mjournalcredit);
                  $af->hpphistorycogs = $cogs->mcogslastcogs;
                  $af->save();
              }

          } else {
              // var_dump('recalculate purchase');
              $mdpurchase = MDPurchase::on(Auth::user()->db_name)->where('mhpurchaseno',$af->transno)->get();
              foreach($mdpurchase as $mdp){
                  $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$mdp->mdpurchasegoodsid)->first();
                  $warehousegoods = MGoodsWarehouse::on(Auth::user()->db_name)->where('mgoodscode',$mdp->mdpurchasegoodsid)->where('mwarehouseid',$mdp->mdpurchasegoodsidwhouse)->first();
                  $mgoods->mgoodsstock += $mdp->mdpurchasegoodsqty;
                  $mgoods->save();
                  $warehousegoods->stock += $mdp->mdpurchasegoodsqty;
                  $warehousegoods->save();
                  $mdp->cogs_ref = IntegrityHelper::updateCOGS($mgoods,$mdp,$mdp->mdpurchasegoodsqty,$af,$remarks = "Revisi Pembelian Turunan");
                  $mdp->save();
              }
          }
      }

    }

    public static function recalculateTransactionFrom($date){

        $affected_history = HPPHistory::on(Auth::user()->db_name)->where('hpphistorydate','>=',Carbon::parse($date))->where('void',0)->orderBy('hpphistorydate','asc')->get();

        // var_dump('affecting '.count($affected_history).' histories');
        $count = 0;

        foreach($affected_history as $af){
            $count++;
            // var_dump($af->id);
            // $loop_date = Carbon::parse($date)->addDays($i);
            // var_dump('loop date '.$loop_date);
            // $mdinvoices = MDInvoice::on(Auth::user()->db_name)->whereDate('mdinvoicedate','=',$loop_date)->get();
            if($af->type == 'sales'){
              var_dump('recalculate sales');
              var_dump('-------------------------------------------------');
                $mdinvoices = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$af->transno)->get();
                foreach($mdinvoices as $mdi){
                    $hpp_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode','5100.01')->first();

                    $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$mdi->mdinvoicegoodsid)->first();
                    $goodswarehouse = MGoodsWarehouse::on(Auth::user()->db_name)->where('mgoodscode',$mgoods->mgoodscode)->where('mwarehouseid',$mdi->mdinvoicegoodsidwhouse)->first();

                    $persediaan_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$mgoods->mgoodscoa)->first();

                    $hpp_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$mdi->mhinvoiceno)->where('mjournalcoa','5100.01')->first();
                    $persediaan_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$mdi->mhinvoiceno)->where('mjournalcoa','1105.01')->first();
                    $hpp_coa->update_saldo('-',$hpp_journal->mjournaldebit);
                    $persediaan_coa->update_saldo('+',$persediaan_journal->mjournalcredit);

                    $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mdi->mdinvoicegoodsid)->first();
                    // var_dump('cogs '.$cogs->mcogslastcogs);
                    $hpp_journal->mjournaldebit = $mdi->mdinvoicegoodsqty * $cogs->mcogslastcogs;
                    // var_dump('debit '.$hpp_journal->mjournaldebit);
                    $hpp_journal->save();
                    $persediaan_journal->mjournalcredit = $mdi->mdinvoicegoodsqty * $cogs->mcogslastcogs;
                    // var_dump('credit '.$persediaan_journal->mjournalcredit);
                    $persediaan_journal->save();
                    $hpp_coa->update_saldo('+',$hpp_journal->mjournaldebit);
                    $persediaan_coa->update_saldo('-',$persediaan_journal->mjournalcredit);
                    $af->hpphistorycogs = $cogs->mcogslastcogs;
                    $af->save();


                    $goodswarehouse->stock -= $mdi->mdinvoicegoodsqty;
                    $goodswarehouse->save();
                    $mgoods->mgoodsstock -= $mdi->mdinvoicegoodsqty;
                    $mgoods->save();

                    // var_dump('stock '.$mgoods->mgoodsstock);
                    $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();

                    $historyTime = Carbon::parse($af->hpphistorydate);
                    $hour = $historyTime->hour;
                    $minute = $historyTime->minute;
                    $second = $historyTime->second;

                    // save cogs log
                    $h = new HPPHistory;
                    $h->setConnection(Auth::user()->db_name);
                    $h->hpphistorygoodsid = $mgoods->mgoodscode;
                    $h->hpphistorypurchase = 0;
                    $h->hpphistoryqty = $goodswarehouse->stock;
                    $h->hpphistorycogs = $af->hpphistorycogs;
                    $h->lastcogs = $af->lastcogs;
                    $h->lastqty = $goodswarehouse->stock + $mdi->mdinvoicegoodsqty;
                    $h->type = 'sales';
                    $h->usage = $mdi->mdinvoicegoodsqty;
                    $h->transno = $mdi->mhinvoiceno;
                    $h->buyprice = 0;
                    $h->hpphistoryremarks = "Revisi Penjualan Turunan";
                    $h->branchid = $branch->mbranchcode;
                    $h->hpphistorydate = Carbon::parse($mdi->mdinvoicedate)->addHour($hour)->addMinute($minute)->addSecond($second+$count);
                    $h->save();
                    $h->created_at = $af->created_at;
                    $h->save();

                    $af->void =1;
                    $af->save();

                }

            } else {
                var_dump('recalculate purchase');
                var_dump('-------------------------------------------------');
                $mdpurchase = MDPurchase::on(Auth::user()->db_name)->where('mhpurchaseno',$af->transno)->get();
                var_dump(' ID '.$af->id);
                foreach($mdpurchase as $mdp){
                    $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$mdp->mdpurchasegoodsid)->first();
                    $goodswarehouse = MGoodsWarehouse::on(Auth::user()->db_name)->where('mgoodscode',$mgoods->mgoodscode)->where('mwarehouseid',$mdp->mdpurchasegoodsidwhouse)->first();

                    if($count == 1){
                      $last_history = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('hpphistorydate','<',Carbon::parse($date))->where('void',0)->orderBy('hpphistorydate','asc')->get()->last();
                      if($last_history != null){
                          var_dump('last history '.$last_history->hpphistoryqty);
                          $goodswarehouse->stock = $last_history->hpphistoryqty;
                          $goodswarehouse->save();
                      } else {
                        var_dump('no last history');
                        $goodswarehouse->stock = 0;
                        $goodswarehouse->save();
                      }

                    }
                    // $mgoods->mgoodsstock += $mdp->mdpurchasegoodsqty;
                    // $mgoods->save();
                    $isFirstHistory = false;
                    if($goodswarehouse->stock == 0){
                      $isFirstHistory = true;
                    }
                    $goodswarehouse->stock += $mdp->mdpurchasegoodsqty;
                    var_dump('stock warehouse '.$goodswarehouse->mgoodscode.' '.$goodswarehouse->stock);
                    $goodswarehouse->save();
                    $mdp->cogs_ref = IntegrityHelper::updateCOGS($mgoods,$mdp,$mdp->mdpurchasegoodsqty,$af,$remarks = "Revisi Pembelian Turunan",$isFirstHistory,$count);
                    $mdp->save();
                }
            }
        }
    }

    /*
     *  on create purchase
     */
    public static function calculateCOGS($mgoods,$mdpurchase,$buy_amount,$purchaseno,$remarks = "Pembelian"){

        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();

        $lastcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->where('type','purchase')->where('branchid',$branch->mbranchcode)->get()->last();
        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->where('branchid',$branch->mbranchcode)->first();
        $lastcogsvalue = 0;
        $lastqtysvalue = 0;
        $cogs_num = 0;
        $warehousestock = MGoodsWarehouse::on(Auth::user()->db_name)->where('mgoodscode',$mgoods->mgoodscode)->where('mwarehouseid',$mdpurchase->mdpurchasegoodsidwhouse)->first();
        if($cogs == null){
            // var_dump('cogs null');
            $cogs = new MCOGS;
            $cogs->setConnection(Auth::user()->db_name);
            $cogs->mcogsgoodscode = $mgoods->mgoodscode;
            $cogs->mcogsgoodsname = $mgoods->mgoodsname;
            $cogs->mcogsgoodstotalqty = $buy_amount;
            $cogs->mcogslastcogs = $mdpurchase->mdpurchasegoodsgrossamount / $buy_amount;
            $cogs->mcogsremarks = $remarks;
            $cogs->branchid = $branch->mbranchcode;
            $cogs->save();
            $cogs_num = $cogs->mcogslastcogs;
        } else {
            // var_dump($mgoods->mgoodsstock.' - '.$buy_amount);

            $last_stock = $warehousestock->stock - $buy_amount;
            $histories =  HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->get();
            $last_history = $histories->last();
            $lastqtysvalue = $last_history->hpphistoryqty;
            $lastcogsvalue = $last_history->hpphistorycogs;
            // var_dump('last stock '.$last_stock);
            // var_dump('last stock '.$lastcogsvalue);
            // var_dump('mdpurchasegoodsgrossamount '.$mdpurchasegoodsgrossamount);
            // var_dump('all stock '.$mgoods->mgoodsstock);
            $cogs_num = (($last_stock * $lastcogsvalue) + $mdpurchase->mdpurchasegoodsgrossamount ) / $warehousestock->stock;

            $cogs->mcogslastcogs = $cogs_num;
            $cogs->mcogsgoodstotalqty = $warehousestock->stock;
            $cogs->save();
        }

        $now = Carbon::now();
        $hour = $now->hour;
        $minute = $now->minute;
        $second = $now->second;

        // save cogs log
        $h = new HPPHistory;
        $h->setConnection(Auth::user()->db_name);
        $h->hpphistorygoodsid = $mgoods->mgoodscode;
        $h->hpphistorypurchase = $mdpurchase->mdpurchasegoodsgrossamount;
        $h->hpphistoryqty = $warehousestock->stock;
        $h->hpphistorycogs = $cogs_num;
        $h->lastcogs = $lastcogsvalue;
        $h->lastqty = $lastqtysvalue;
        $h->type = 'purchase';
        $h->usage = $buy_amount;
        $h->transno = $purchaseno;
        $h->buyprice = ($mdpurchase->mdpurchasegoodsgrossamount / $buy_amount);
        $h->hpphistoryremarks = $remarks;
        $h->branchid = $branch->mbranchcode;
        $h->hpphistorydate = Carbon::parse($mdpurchase->mdpurchasedate)->addHour($hour)->addMinute($minute)->addSecond($second);
        $h->save();
        return $h->id;

    }

    /*
     *  on update purchase
     */
    public static function updateCOGS($mgoods,$mdpurchase,$buy_amount,$edited_history,$remarks = "Revisi Pembelian",$isFirstHistory = false,$sequence = 1){
        // $lastcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->where('type','purchase')->where('created_at','<',Carbon::parse($edited_history->created_at))->orderBy('created_at','asc')->get()->last();
        $edited_history->void = 1;
        $edited_history->save();
        var_dump('edit historydate '.$edited_history->hpphistorydate);
        $listcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->where('hpphistorydate','<',Carbon::parse($edited_history->hpphistorydate))->orderBy('id','asc')->get();
        // $alllistcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->orderBy('id','asc')->get();
        //
        // foreach ($alllistcogs as $all) {
        //   var_dump('all_hist '.$all->id);
        //   var_dump('all_target historydate '.$all->hpphistorydate);
        // }

        foreach($listcogs as $li){
          var_dump('hist '.$li->id);
          var_dump('target historydate '.$li->hpphistorydate);
        }
        $lastcogs = $listcogs->last();

        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();
        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->where('branchid',$branch->mbranchcode)->first();
        $cogs_num = 0;

        $goodswarehouse = MGoodsWarehouse::on(Auth::user()->db_name)->where('mgoodscode',$mgoods->mgoodscode)->where('mwarehouseid',$mdpurchase->mdpurchasegoodsidwhouse)->first();

        $lastcogsvalue = 0;
        $lastqtyvalue = 0;

        if($lastcogs != null){
          var_dump('taking historydate '.$lastcogs->hpphistorydate);
          var_dump('last_cogs_id '.$lastcogs->id);
            // var_dump('lastcogs id = '.$lastcogs->id);
            if($isFirstHistory){
              var_dump('first nol');
              $lastcogsvalue = 0;
              $lastqtyvalue = 0;
            } else {
              $lastcogsvalue = $lastcogs->hpphistorycogs;
              $lastqtyvalue = $lastcogs->hpphistoryqty;
            }


            var_dump('lastcogsvalue '.$lastcogsvalue);
            var_dump('lastqtyvalue '.$lastqtyvalue);
            // var_dump('goods_stock '.$mgoods->mgoodsstock);

            $last_stock = $lastqtyvalue;
            // var_dump('last_stock '.$last_stock);
            $cogs->mcogsgoodstotalqty -= $lastcogs->hpphistoryqty;
            var_dump('(('.$last_stock.' * '.$lastcogsvalue.' + '.$mdpurchase->mdpurchasegoodsgrossamount.' / '.$goodswarehouse->stock.' ))');
            // $cogs_num = (($last_stock * $lastcogsvalue) + $mdpurchase->mdpurchasegoodsgrossamount ) / $mgoods->mgoodsstock;
            $cogs_num = (($last_stock * $lastcogsvalue) + $mdpurchase->mdpurchasegoodsgrossamount ) / $goodswarehouse->stock;

            var_dump('cogs_num '.$cogs_num);
            // $lastcogsvalue = $cogs->mcogslastcogs;
            $cogs->mcogslastcogs = $cogs_num;
            $cogs->mcogsgoodstotalqty = $goodswarehouse->stock;
            $cogs->save();
        } else {
            var_dump('taking null');
            // var_dump('is first history');
            $cogs_num = $mdpurchase->mdpurchasegoodsgrossamount / $mdpurchase->mdpurchasegoodsqty;

            // var_dump('cogs_num '.$cogs_num);
            // $lastcogsvalue = $cogs->mcogslastcogs;
            $cogs->mcogslastcogs = $cogs_num;
            $cogs->mcogsgoodstotalqty = $mdpurchase->mdpurchasegoodsqty;
            $cogs->save();
            $mgoods->mgoodsstock = $mdpurchase->mdpurchasegoodsqty;
            $mgoods->save();
        }



        // void edited history
        // $lastcogs->void = 1;

        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();

        $historyTime = Carbon::parse($edited_history->hpphistorydate);
        $hour = $historyTime->hour;
        $minute = $historyTime->minute;
        $second = $historyTime->second;

        // save cogs log
        $h = new HPPHistory;
        $h->setConnection(Auth::user()->db_name);
        $h->hpphistorygoodsid = $mgoods->mgoodscode;
        $h->hpphistorypurchase = $mdpurchase->mdpurchasegoodsgrossamount;
        $h->hpphistoryqty = $goodswarehouse->stock;
        $h->hpphistorycogs = $cogs_num;
        $h->lastcogs = $lastcogsvalue;
        $h->type = 'purchase';
        $h->usage = $mdpurchase->mdpurchasegoodsqty;
        $h->lastqty = $lastqtyvalue;
        $h->transno = $mdpurchase->mhpurchaseno;
        $h->buyprice = ($mdpurchase->mdpurchasegoodsgrossamount / $mdpurchase->mdpurchasegoodsqty);
        $h->hpphistoryremarks = $remarks;
        $h->branchid = $branch->mbranchcode;
        // $h->hpphistorydate = Carbon::parse($mdpurchase->mdpurchasedate)->addHour($hour)->addMinute($minute)->addSecond($second+$sequence);
        $h->hpphistorydate = Carbon::parse($mdpurchase->mdpurchasedate)->addHour($hour)->addMinute($minute)->addSecond($second);
        $h->save();

        $h->created_at = $edited_history->created_at;
        $h->save();

        return $h->id;

    }

    /*
     *  on delete purchase
     */
    public static function deleteCOGS($mgoods,$mdpurchasegoodsgrossamount,$purchaseno,$remarks = "",$mstockcardwhouse){

        $wh = MWarehouse::on(Auth::user()->db_name)->where('id',$mstockcardwhouse)->first();
        $branchid = $wh->mwarehousebranchid;
        $lastcogs = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->where('type','purchase')->where('branchid',$branchid)->where('transno',$purchaseno)->first();
        var_dump('****************');
        var_dump('last cogs delete '.$lastcogs->id);
        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->where('branchid',$branchid)->first();
        // $cogs_num = 0;
        //
        //     // $cogs->mcogslastcogs -= $lastcogs->hpphistorycogs;
        //     $cogs->mcogsgoodstotalqty = $lastcogs->lastqty;
        //     $cogs->mcogslastcogs = $lastcogs->lastcogs;
        //     $cogs->save();

        $lastcogs->void = 1;
        $lastcogs->save();

    }


    /*
     *  on delete sales
     */
    public static function restoreCOGS($mgoods,$warehousegoods,$invoiceno,$usage,$remarks = ""){
        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();
        $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->where('branchid',$branch->mbranchcode)->first();
        $history = HPPHistory::on(Auth::user()->db_name)->where('transno',$invoiceno)->first();
        $history->void = 1;
        $history->save();
        $cogs->mcogsgoodstotalqty = $history->prev()->hpphistoryqty;
        $cogs->mcogslastcogs = $history->prev()->hpphistorycogs;
        $cogs->save();

        $warehousegoods->stock = $cogs->mcogsgoodstotalqty;
        $mgoods->save();

        // var_dump('STOCK dalam helper '.$mgoods->mgoodsstock);
        $start_state = $history->prev();

        $affected_transaction = HPPHistory::on(Auth::user()->db_name)->where('id','>', $start_state->id)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('void',0)->where('transno','!=',$invoiceno)->where('branchid',$branch->mbranchcode)->get();
        $count = 0;
        $first_purcahse_since = true;
        foreach($affected_transaction as $tr){
            $count++;
            if($tr->type == 'purchase'){
                if($first_purcahse_since){
                    $tr->hpphistoryqty += $usage;
                    $tr->lastqty += $usage;
                    $tr->hpphistorypurchase = ($tr->usage * $tr->buyprice);
                    $first_purcahse_since = false;
                }

//                $hpp = (($mgoods->mgoodsstock * $tr->lastcogs) + ($tr->usage * $tr->buyprice)) / ($mgoods->mgoodsstock + $tr->usage);
                $hpp = (($warehousegoods->stock * $tr->lastcogs) + ($tr->usage * $tr->buyprice)) / ($warehousegoods->stock + $tr->usage);
                // var_dump('hpp '.$tr->id.' - '.$tr->transno.' = '.$hpp);
                $tr->hpphistorycogs = $hpp;
                $tr->save();

                $mgoods->mgoodsstock += $tr->usage;
                $mgoods->save();
                $warehousegoods->stock += $tr->usage;
                $warehousegoods->save();

                $cogs->mcogslastcogs = $hpp;
                $cogs->mcogsgoodstotalqty = $warehousegoods->stock;
                $cogs->save();
                // var_dump('stock '.$mgoods->mgoodsstock);
            } else if($tr->type == 'sales') {
                // var_dump('sales '.$tr->id.' - '.$tr->transno);
                $mgoods->mgoodsstock -= $tr->usage;
                $mgoods->save();
                $warehousegoods->stock -= $tr->usage;
                $warehousegoods->save();

                $tr->hpphistorycogs = $cogs->mcogslastcogs;
                $tr->lastcogs = $cogs->mcogslastcogs;
                $tr->lastqty = $tr->prev()->hpphistoryqty;
                $tr->hpphistoryqty = $warehousegoods->stock;
                $tr->save();
                // var_dump('stock '.$mgoods->mgoodsstock);
            } else {

            }
        }
    }
}
