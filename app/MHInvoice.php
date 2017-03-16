<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MConfig;
use Auth;
use App\Helper\DBHelper;
use App\Helper\IntegrityHelper;
use Carbon\Carbon;
use App\MCUSTOMER;
use App\MStockCard;
use App\MARCard;
use App\MDInvoice;
use DB;
use Exception;
use App\MJournal;
use App\MCOA;
use App\HPPHistory;

class MHInvoice extends Model
{
    protected $table = 'mhinvoice';
    protected static function boot(){
  		parent::boot();
  		static::addGlobalScope('actives', function(Builder $builder) {
  				$builder->where('void', '=', 0);
                $builder->orderBy('mhinvoicedate','desc');
  		});
      static::created(function($mhinvoice){
        $mhinvoice->update_prefix_status();
      });
  	}

    public function update_prefix_status(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixinvoicecount = $conf->msysprefixinvoicecount+1;
      $conf->msysprefixinvoicelastcount = $conf->get_last_count_format($conf->msysprefixinvoicecount);
      $conf->save();
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      try{
        DBHelper::configureConnection(Auth::user()->db_alias);
        DB::connection(Auth::user()->db_name)->select(DB::raw('call autogen("mhinvoice","'.$conf->msysprefixinvoice.'",'.$conf->msysprefixinvoicecount.',"mhinvoiceno",'.$this->id.')'));
      } catch(Exception $e){
        var_dump($e);
        return $e;
      }

    }

    public function has_item_in_warehouses($warehouse_ids){
        $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$this->mhinvoiceno)->whereIn('mdinvoicegoodsidwhouse',$warehouse_ids)->get()->toArray();
        return (sizeof($details) > 0);
    }

    public static function start_transaction($request){
      $allow_minus = MConfig::on(Auth::user()->db_name)->where('id',1)->first()->msysinventallowminus;
      DB::connection(Auth::user()->db_name)->beginTransaction();
      try{
        $sum_hpp_journal = 0;
        $sum_persediaan_journal = 0;

        $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
        //insert header
        $invoice_header = new MHInvoice;
        $invoice_header->setConnection(Auth::user()->db_name);
        $invoice_header->mhinvoicedate = Carbon::parse($request->date);
        $invoice_header->mhinvoicesubtotal = $request->subtotal + $request->discount;
        $invoice_header->mhinvoicetaxtotal = $request->tax;
        $invoice_header->mhinvoicediscounttotal = $request->discount;
        $invoice_header->mhinvoicegrandtotal = $request->subtotal + $request->tax;
        if($request->tax > 0){
          $invoice_header->mhinvoicewithppn = 1;
        } else {
          $invoice_header->mhinvoicewithppn = 0;
        }
        $customer = MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$request->mcustomerid)->first();
        $invoice_header->mhinvoicecustomerid = $customer->mcustomerid;
        $invoice_header->mhinvoicecustomername = $customer->mcustomername;
        $invoice_header->mhinvoiceduedate = Carbon::now()->addDays($customer->mcustomerdefaultar);
        $invoice_header->save();

        /*
         * Auto or manual invoice no
         */
        if($request->autogen == true){
            $invoice_header->autogenproc();
        } else {
            $invoice_header->mhinvoiceno = $request->no;
        }
        $invoice_header->save();

        $header = MHInvoice::on(Auth::user()->db_name)->where('id',$invoice_header->id)->first();

        // insert journal
        MJournal::record_journal($header->mhinvoiceno,'Penjualan',$conf->msyspayaraccount,$header->mhinvoicegrandtotal,0,"","","",$invoice_header->mhinvoicedate);
        MJournal::record_journal($header->mhinvoiceno,'Penjualan',$conf->msysaccinv,0,$header->mhinvoicesubtotal,"","","",$invoice_header->mhinvoicedate);
        MJournal::record_journal($header->mhinvoiceno,'Penjualan','2102.01',0,$header->mhinvoicetaxtotal,"","","",$invoice_header->mhinvoicedate);

        $coa_piutang = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msyspayaraccount)->first();
        $coa_piutang->update_saldo('+',$header->mhinvoicegrandtotal);
        $coa_sales = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccinv)->first();
        $coa_sales->update_saldo('+',$header->mhinvoicesubtotal);
        $coa_tax = MCOA::on(Auth::user()->db_name)->where('mcoacode','2102.01')->first();
        $coa_tax->update_saldo('+',$header->mhinvoicetaxtotal);

        //insert detail
        foreach($request->goods as $g){

          $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g['goods']['mgoodscode'])->first();
          $mgoods->mgoodspriceout = $g['sell_price'];
          $mgoods->save();

          $invoice_detail = new MDInvoice;
          $invoice_detail->setConnection(Auth::user()->db_name);
          $invoice_detail->mhinvoiceno = $header->mhinvoiceno;
          $invoice_detail->mdcustomerid = $customer->mcustomerid;
          $invoice_detail->mdcustomername = $customer->mcustomername;
          $invoice_detail->mdinvoicedate = $header->mhinvoicedate;
          $invoice_detail->mdinvoicegoodsid = $g['goods']['mgoodscode'];
          $invoice_detail->mdinvoicegoodsname = $g['goods']['mgoodsname'];
          $invoice_detail->mdinvoiceunit3 = $g['detail_goods_unit3'];
          $invoice_detail->mdinvoiceunit3conv = $g['detail_goods_unit3_conv'];
          $invoice_detail->mdinvoiceunit3label = $g['detail_goods_unit3_label'];
          $invoice_detail->mdinvoiceunit2 = $g['detail_goods_unit2'];
          $invoice_detail->mdinvoiceunit2conv = $g['detail_goods_unit2_conv'];
          $invoice_detail->mdinvoiceunit2label = $g['detail_goods_unit2_label'];
          $invoice_detail->mdinvoiceunit1 = $g['detail_goods_unit1'];
          $invoice_detail->mdinvoiceunit1conv = $g['detail_goods_unit1_conv'];
          $invoice_detail->mdinvoiceunit1label = $g['detail_goods_unit1_label'];
          $invoice_detail->mdinvoicegoodsqty = $g['usage'];
          $invoice_detail->mdinvoicegoodsprice = $g['goods']['mgoodspriceout'];
          $invoice_detail->mdinvoicegoodsgrossamount = $g['subtotal'];
          $invoice_detail->mdinvoicegoodsdiscount = $g['disc'];
          $invoice_detail->mdinvoicegoodstax = $g['tax'];
          $invoice_detail->saved_unit = $g['saved_unit'];
          $invoice_detail->mdinvoicegoodsidwhouse = $g['warehouse'];
          $invoice_detail->mdinvoiceremarks = $g['remark'];
          $invoice_detail->save();

          //update stock card
          $stock_card = new MStockCard;
          $stock_card->setConnection(Auth::user()->db_name);
          $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
          $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
          $stock_card->mstockcarddate = Carbon::parse($request->date);
          $stock_card->mstockcardtranstype = $request->type;
          $stock_card->mstockcardtransno = $header->mhinvoiceno;
          $stock_card->mstockcardremark = "Transaksi ".$request->type." untuk ".$customer->mcustomername." ".$g['remark'];
          $stock_card->mstockcardstockin = 0;
          $stock_card->mstockcardstockout = $g['usage'];
          $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock - $g['usage'];
        //   $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
          $stock_card->mstockcardwhouse = $g['warehouse'];
          $stock_card->mstockcarduserid = Auth::user()->id;
          $stock_card->mstockcardusername = Auth::user()->name;
          $stock_card->mstockcardeventdate = Carbon::now();
          $stock_card->mstockcardeventtime = Carbon::now();
          $stock_card->edited = 0;
          $stock_card->save();

          // update master barang
          $mgoods->mgoodsstock = $mgoods->mgoodsstock - $g['usage'];
          $mgoods->save();

          // update detail stock refs
          $invoice_detail->stock_ref = $stock_card->id;
          $invoice_detail->save();

          $hpp = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$g['goods']['mgoodscode'])->get()->last();
          $hpp_price = $hpp->hpphistorycogs * $g['usage'];

          // add per item sum
          $sum_hpp_journal += $hpp_price;
          $sum_persediaan_journal += $hpp_price;

          $purchase_histories = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('type','purchase')->where('void',0)->get();
          $last_purchase = $purchase_histories->last();

          // save cogs log
          $h = new HPPHistory;
          $h->setConnection(Auth::user()->db_name);
          $h->hpphistorygoodsid = $mgoods->mgoodscode;
          $h->hpphistorypurchase = 0;
          $h->hpphistoryqty = $mgoods->mgoodsstock;
          $h->hpphistorycogs = $hpp->hpphistorycogs;
          $h->lastcogs = $last_purchase->hpphistorycogs;
          $h->type = 'sales';
          $h->usage = $g['usage'];
          $h->transno = $invoice_detail->mhinvoiceno;
          $h->lastqty = $last_purchase->hpphistoryqty;
          $h->hpphistoryremarks = 'Penjualan';
          $h->save();

          //check allow minus
          if($allow_minus == 0 && ($mgoods->mgoodsstock < 0)){
            DB::connection(Auth::user()->db_name)->rollBack();
            $resp = [
                'status' => 'empty',
                'data' => null
            ];
            return $resp;
          }

        }

        // add sum HPP journal

        MJournal::record_journal($header->mhinvoiceno,'Penjualan',$conf->msysaccsellingexpense,$sum_hpp_journal,0,"","","",$invoice_header->mhinvoicedate);
        MJournal::record_journal($header->mhinvoiceno,'Penjualan',$conf->msysaccstock,0,$sum_persediaan_journal,"","","",$invoice_header->mhinvoicedate);

        $coa_hpp = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccsellingexpense)->first();
        $coa_hpp->update_saldo('-',$sum_hpp_journal);
        $coa_persediaan_barang = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccstock)->first();
        $coa_persediaan_barang->update_saldo('-',$sum_persediaan_journal);

        // update AR table

        $ar = new MARCard;
        $ar->setConnection(Auth::user()->db_name);
        $ar->marcardcustomerid = $customer->mcustomerid;
        $ar->marcardcustomername = $customer->mcustomername;
        $ar->marcarddate = Carbon::parse($request->date);
        $ar->marcardduedate = Carbon::parse($request->duedate);
        $ar->marcardtranstype = $request->type;
        $ar->marcardtransno = $header->mhinvoiceno;
        $ar->marcardremark = "Transaksi ".$request->type." untuk ".$customer->mcustomername." ".$g['remark'];
        $ar->marcardduedate = Carbon::parse($request->date)->addDays($customer->mcustomerdefaultar);
        $ar->marcardtotalinv = $request->subtotal + $request->tax - $request->disc;
        $ar->marcardpayamount = 0;
        $ar->marcardoutstanding = $request->subtotal + $request->tax - $request->disc;
        $ar->marcarduserid = Auth::user()->id;
        $ar->marcardusername = Auth::user()->name;
        $ar->marcardusereventdate = Carbon::now();
        $ar->marcardusereventtime = Carbon::now();
        $ar->marcardwarehouseid = $g['warehouse'];
        $ar->save();

        MJournal::add_prefix();

        DB::connection(Auth::user()->db_name)->commit();
        $resp = [
            'status' => 'ok',
            'data' => $invoice_header
        ];
        return $resp;
      } catch(Exception $e){
        DB::connection(Auth::user()->db_name)->rollBack();
        $resp = [
            'status' => 'err',
            'data' => $e
        ];
        return $resp;
      }

    }

    public function update_transaction($request){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $allow_minus = $conf->msysinventallowminus;

      DB::connection(Auth::user()->db_name)->beginTransaction();
      try{
        $sum_hpp_journal = 0;
        $sum_persediaan_journal = 0;
        //insert header
        $invoice_header = $this;
        $invoice_header->setConnection(Auth::user()->db_name);
        $invoice_header->mhinvoicedate = Carbon::parse($request->date);
        $invoice_header->mhinvoicesubtotal = $request->subtotal + $request->disc;
        $invoice_header->mhinvoicetaxtotal = $request->tax;
        $invoice_header->mhinvoicediscounttotal = $request->discount;
        $invoice_header->mhinvoicegrandtotal = $request->subtotal + $request->tax;
        if($request->tax > 0){
          $invoice_header->mhinvoicewithppn = 1;
        } else {
          $invoice_header->mhinvoicewithppn = 0;
        }
        $customer = MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$request->mcustomerid)->first();
        $invoice_header->mhinvoicecustomerid = $customer->mcustomerid;
        $invoice_header->mhinvoicecustomername = $customer->mcustomername;
        $invoice_header->mhinvoiceduedate = Carbon::now()->addDays($customer->mcustomerdefaultar);
        $invoice_header->save();
        $header = MHInvoice::on(Auth::user()->db_name)->where('id',$invoice_header->id)->first();

        // update header journal
        $journal_piutang = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhinvoiceno)->where('mjournalcoa',$conf->msyspayaraccount)->first();
        $journal_sales = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhinvoiceno)->where('mjournalcoa',$conf->msysaccinv)->first();
        $journal_tax = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhinvoiceno)->where('mjournalcoa','2102.01')->first();

        $coa_piutang = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msyspayaraccount)->first();
        $coa_piutang->update_saldo('-',$journal_piutang->mjournaldebit);

        $coa_sales = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccinv)->first();
        $coa_sales->update_saldo('-',$journal_sales->mjournalcredit);

        $coa_tax = MCOA::on(Auth::user()->db_name)->where('mcoacode','2102.01')->first();
        $coa_tax->update_saldo('-',$journal_tax->mjournalcredit);

        $journal_piutang->mjournaldebit = $header->mhinvoicegrandtotal;
        $coa_piutang->update_saldo('+',$header->mhinvoicegrandtotal);
        $journal_piutang->save();

        $journal_sales->mjournalcredit = $header->mhinvoicesubtotal;
        $coa_sales->update_saldo('+',$header->mhinvoicesubtotal);
        $journal_sales->save();

        $journal_tax->mjournalcredit = $header->mhinvoicetaxtotal;
        $coa_tax->update_saldo('+',$header->mhinvoicetaxtotal);
        $journal_tax->save();

        $journal_hpp = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhinvoiceno)->where('mjournalcoa',$conf->msysaccsellingexpense)->first();
        $journal_persediaan = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhinvoiceno)->where('mjournalcoa',$conf->msysaccstock)->first();

        $coa_hpp = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccsellingexpense)->first();
        $coa_persediaan_barang = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccstock)->first();

        $coa_hpp->update_saldo('+',$journal_hpp->mjournaldebit);
        $coa_persediaan_barang->update_saldo('+',$journal_persediaan->mjournalcredit);

        $journal_persediaan->mjournalcredit = 0;
        $journal_hpp->mjournaldebit = 0;

        // void all detail dlu biar tau mana yg di hapus
        $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$invoice_header->mhinvoiceno)->get();
        foreach ($details as $dt) {
          $dt->void = 1;
          $dt->mdinvoicedate = Carbon::parse($request->date);
          $dt->save();
        }

        foreach ($request->goods as $g) {
          $invoice_detail = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$g['goods']['mgoodscode'])->where('mhinvoiceno',$header->mhinvoiceno)->first();

          if($invoice_detail != null){
              $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g['goods']['mgoodscode'])->first();
              $mgoods->mgoodspriceout = $g['sell_price'];
              $mgoods->save();
              $last_stock = MStockCard::on(Auth::user()->db_name)->where('mstockcardtransno',$invoice_detail->mhinvoiceno)->where('mstockcardgoodsid',$mgoods->mgoodscode)->orderBy('created_at','desc')->get()->first();
              $old_qty = $invoice_detail->mdinvoicegoodsqty;

              $invoice_detail->mhinvoiceno = $header->mhinvoiceno;
              $invoice_detail->mdcustomerid = $customer->mcustomerid;
              $invoice_detail->mdcustomername = $customer->mcustomername;
              $invoice_detail->mdinvoicedate = $header->mhinvoicedate;
              $invoice_detail->mdinvoicegoodsid = $g['goods']['mgoodscode'];
              $invoice_detail->mdinvoicegoodsname = $g['goods']['mgoodsname'];
              $invoice_detail->mdinvoiceunit3 = $g['detail_goods_unit3'];
              $invoice_detail->mdinvoiceunit3conv = $g['detail_goods_unit3_conv'];
              $invoice_detail->mdinvoiceunit3label = $g['detail_goods_unit3_label'];
              $invoice_detail->mdinvoiceunit2 = $g['detail_goods_unit2'];
              $invoice_detail->mdinvoiceunit2conv = $g['detail_goods_unit2_conv'];
              $invoice_detail->mdinvoiceunit2label = $g['detail_goods_unit2_label'];
              $invoice_detail->mdinvoiceunit1 = $g['detail_goods_unit1'];
              $invoice_detail->mdinvoiceunit1conv = $g['detail_goods_unit1_conv'];
              $invoice_detail->mdinvoiceunit1label = $g['detail_goods_unit1_label'];
              $invoice_detail->mdinvoicegoodsqty = $g['usage'];
              $invoice_detail->mdinvoicegoodsprice = $g['goods']['mgoodspriceout'];
              $invoice_detail->mdinvoicegoodsgrossamount = $g['subtotal'];
              $invoice_detail->mdinvoicegoodsdiscount = $g['disc'];
              $invoice_detail->mdinvoicegoodstax = $g['tax'];
              $invoice_detail->saved_unit = $g['saved_unit'];
              if($g['warehouse'] != ""){
                $invoice_detail->mdinvoicegoodsidwhouse = $g['warehouse'];
              }
              $invoice_detail->mdinvoiceremarks = "";
              $invoice_detail->void = 0;
              $invoice_detail->save();

              //stock card
              if($old_qty != $g['usage']){
                //in dengan qty lama
                $stock_card = new MStockCard;
                $stock_card->setConnection(Auth::user()->db_name);
                $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
                $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
                $stock_card->mstockcarddate = Carbon::parse($request->date);
                $stock_card->mstockcardtranstype = $request->type;
                $stock_card->mstockcardtransno = $header->mhinvoiceno;
                $stock_card->mstockcardremark = "Revisi Transaksi ".$request->type." oleh ".Auth::user()->name."/".Auth::user()->id." ".$g['remark'];
                $stock_card->mstockcardstockin = $old_qty;
                $stock_card->mstockcardstockout = 0;
                $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock += $old_qty;
                $stock_card->mstockcardwhouse = $g['warehouse'];
                $stock_card->mstockcarduserid = Auth::user()->id;
                $stock_card->mstockcardusername = Auth::user()->name;
                $stock_card->mstockcardeventdate = Carbon::now();
                $stock_card->mstockcardeventtime = Carbon::now();
                $stock_card->edited = 1;
                $stock_card->void = 0;
                $stock_card->save();

                if($old_qty != $g['usage']){
                    $mgoods->mgoodsstock += $last_stock->mstockcardstockout;
                }
                $mgoods->save();

                //out dengan qty baru
                $stock_card = new MStockCard;
                $stock_card->setConnection(Auth::user()->db_name);
                $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
                $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
                $stock_card->mstockcarddate = Carbon::parse($request->date);
                $stock_card->mstockcardtranstype = $request->type;
                $stock_card->mstockcardtransno = $header->mhinvoiceno;
                $stock_card->mstockcardremark = "Revisi Transaksi ".$request->type." oleh ".Auth::user()->name."/".Auth::user()->id." ".$g['remark'];
                $stock_card->mstockcardstockin = 0;
                $stock_card->mstockcardstockout = $g['usage'];
                $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock -= $g['usage'];
                $stock_card->mstockcardwhouse = $g['warehouse'];
                $stock_card->mstockcarduserid = Auth::user()->id;
                $stock_card->mstockcardusername = Auth::user()->name;
                $stock_card->mstockcardeventdate = Carbon::now();
                $stock_card->mstockcardeventtime = Carbon::now();
                $stock_card->edited = 1;
                $stock_card->void = 0;
                $stock_card->save();

                // $mgoods->mgoodsstock -= $g['usage'];
                $mgoods->save();

                // update detail stock refs
                $invoice_detail->stock_ref = $stock_card->id;
                $invoice_detail->save();

                //check allow minus
                if($allow_minus == 0 && ($mgoods->mgoodsstock < 0)){
                  DB::connection(Auth::user()->db_name)->rollBack();
                  $resp = [
                      'status' => 'empty',
                      'data' => null
                  ];
                  return $resp;
                }

                // update journal

                $hpp_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccsellingexpense)->first();
                $hpp = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$g['goods']['mgoodscode'])->get()->last();
                $last_amount = $old_qty * $hpp->hpphistorycogs;
                $persediaan_barang_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccstock)->first();
                $new_amount = $hpp->hpphistorycogs * $g['usage'];
                $hpp_coa->update_saldo('-',$new_amount);
                $persediaan_barang_coa->update_saldo('-',$new_amount);
                var_dump('tambah '.$new_amount);
                $sum_hpp_journal += $new_amount;
                $sum_persediaan_journal += $new_amount;

              } else {
                // data tdk berubah
                $journal_hpp->mjournaldate = Carbon::parse($request->date);

                $journal_hpp->save();

                $journal_persediaan->mjournaldate = Carbon::parse($request->date);
                $journal_persediaan->save();

                $invoice_detail->void=0;
                $invoice_detail->save();

                $hpp_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccsellingexpense)->first();
                $hpp = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$g['goods']['mgoodscode'])->get()->last();
                $last_amount = $old_qty * $hpp->hpphistorycogs;
                $persediaan_barang_coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccstock)->first();
                $new_amount = $hpp->hpphistorycogs * $g['usage'];
                $hpp_coa->update_saldo('-',$new_amount);
                $persediaan_barang_coa->update_saldo('-',$new_amount);
                var_dump('before sum '.$sum_hpp_journal);
                var_dump('tambah else '.$new_amount);
                $sum_hpp_journal += $new_amount;
                $sum_persediaan_journal += $new_amount;
              }
              var_dump('sum '.$sum_hpp_journal);
          } else {
              // newdata
              $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g['goods']['mgoodscode'])->first();

              $invoice_detail = new MDInvoice;
              $invoice_detail->setConnection(Auth::user()->db_name);
              $invoice_detail->mhinvoiceno = $header->mhinvoiceno;
              $invoice_detail->mdcustomerid = $customer->mcustomerid;
              $invoice_detail->mdcustomername = $customer->mcustomername;
              $invoice_detail->mdinvoicedate = $header->mhinvoicedate;
              $invoice_detail->mdinvoicegoodsid = $g['goods']['mgoodscode'];
              $invoice_detail->mdinvoicegoodsname = $g['goods']['mgoodsname'];
              $invoice_detail->mdinvoiceunit3 = $g['detail_goods_unit3'];
              $invoice_detail->mdinvoiceunit3conv = $g['detail_goods_unit3_conv'];
              $invoice_detail->mdinvoiceunit3label = $g['detail_goods_unit3_label'];
              $invoice_detail->mdinvoiceunit2 = $g['detail_goods_unit2'];
              $invoice_detail->mdinvoiceunit2conv = $g['detail_goods_unit2_conv'];
              $invoice_detail->mdinvoiceunit2label = $g['detail_goods_unit2_label'];
              $invoice_detail->mdinvoiceunit1 = $g['detail_goods_unit1'];
              $invoice_detail->mdinvoiceunit1conv = $g['detail_goods_unit1_conv'];
              $invoice_detail->mdinvoiceunit1label = $g['detail_goods_unit1_label'];
              $invoice_detail->mdinvoicegoodsqty = $g['usage'];
              $invoice_detail->mdinvoicegoodsprice = $g['goods']['mgoodspriceout'];
              $invoice_detail->mdinvoicegoodsgrossamount = $g['subtotal'];
              $invoice_detail->mdinvoicegoodsdiscount = $g['disc'];
              $invoice_detail->mdinvoicegoodstax = $g['tax'];
              $invoice_detail->saved_unit = $g['saved_unit'];
              $invoice_detail->mdinvoicegoodsidwhouse = $g['warehouse'];
              $invoice_detail->save();

              //update stock card
              $stock_card = new MStockCard;
              $stock_card->setConnection(Auth::user()->db_name);
              $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
              $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
              $stock_card->mstockcarddate = Carbon::parse($request->date);
              $stock_card->mstockcardtranstype = $request->type;
              $stock_card->mstockcardtransno = $header->mhinvoiceno;
              $stock_card->mstockcardremark = "Revisi Transaksi ".$request->type." oleh ".Auth::user()->name."/".Auth::user()->id." ".$g['remark'];
              $stock_card->mstockcardstockin = 0;
              $stock_card->mstockcardstockout = $g['usage'];
            //   $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock - $g['usage'];
              $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
              $stock_card->mstockcardwhouse = $g['warehouse'];
              $stock_card->mstockcarduserid = Auth::user()->id;
              $stock_card->mstockcardusername = Auth::user()->name;
              $stock_card->mstockcardeventdate = Carbon::now();
              $stock_card->mstockcardeventtime = Carbon::now();
              $stock_card->edited = 0;
              $stock_card->save();

              // update master barang
            //   $mgoods->mgoodsstock = $stock_card->mstockcardstocktotal;
              $mgoods->mgoodsstock = $mgoods->mgoodsstock - $g['usage'];
              $mgoods->save();

              //check allow minus
              if($allow_minus == 0 && ($mgoods->mgoodsstock < 0)){
                DB::connection(Auth::user()->db_name)->rollBack();
                $resp = [
                    'status' => 'empty',
                    'data' => null
                ];
                return $resp;
              }

              $cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
              $hpp_price = $g['usage'] * $cogs->mcogslastcogs;
              $sum_hpp_journal += $hpp_price;
              $sum_persediaan_journal += $hpp_price;


              $coa_hpp = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccsellingexpense)->first();
              $coa_hpp->update_saldo('-',$hpp_price);
              $coa_persediaan_barang = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccstock)->first();
              $coa_persediaan_barang->update_saldo('-',$hpp_price);

            //   $hpp = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$g['goods']['mgoodscode'])->get()->last();
            //   $new_amount = $hpp->hpphistorycogs * $g['usage'];
            //   $journal_hpp->mjournaldebit += $new_amount;
            //   $journal_persediaan->mjournalcredit += $new_amount;
            //   $journal_hpp->save();
            //   $journal_persediaan->save();

              $purchase_histories = HPPHistory::on(Auth::user()->db_name)->where('hpphistorygoodsid',$mgoods->mgoodscode)->where('type','purchase')->where('void',0)->get();
              $last_purchase = $purchase_histories->last();

              // save cogs log
              $h = new HPPHistory;
              $h->setConnection(Auth::user()->db_name);
              $h->hpphistorygoodsid = $mgoods->mgoodscode;
              $h->hpphistorypurchase = 0;
              $h->hpphistoryqty = $mgoods->mgoodsstock;
              $h->hpphistorycogs = $hpp->hpphistorycogs;
              $h->lastcogs = $last_purchase->hpphistorycogs;
              $h->type = 'sales';
              $h->usage = $g['usage'];
              $h->transno = $invoice_detail->mhinvoiceno;
              $h->lastqty = $last_purchase->hpphistoryqty;
              $h->hpphistoryremarks = 'Penjualan';
              $h->save();
          }

        }

        // update AR
        $ar = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$header->mhinvoicecustomerid)->where('marcardtransno',$header->mhinvoiceno)->first();
        $ar->marcardcustomerid = $customer->mcustomerid;
        $ar->marcardcustomername = $customer->mcustomername;
        $ar->marcarddate = Carbon::parse($request->date);
        $ar->marcardduedate = Carbon::parse($request->duedate);
        $ar->marcardtranstype = $request->type;
        $ar->marcardtransno = $header->mhinvoiceno;
        $ar->marcardremark = "Revisi Transaksi ".$request->type." untuk ".$customer->mcustomername." ";
        $ar->marcardduedate = Carbon::parse($request->date)->addDays($customer->mcustomerdefaultar);
        $ar->marcardtotalinv = $request->subtotal + $request->tax - $request->disc;
        $ar->marcardpayamount = 0;
        $ar->marcardoutstanding = $request->subtotal + $request->tax - $request->disc;
        $ar->marcarduserid = Auth::user()->id;
        $ar->marcardusername = Auth::user()->name;
        $ar->marcardusereventdate = Carbon::now();
        $ar->marcardusereventtime = Carbon::now();
        $ar->marcardwarehouseid = $g['warehouse'];
        $ar->save();

        //voided details
        $voided_details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$invoice_header->mhinvoiceno)->where('void',1)->get();
        foreach ($voided_details as $v) {
            $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$v->mdinvoicegoodsid)->first();
            var_dump('STOCK sebelum helper '.$mgoods->mgoodsstock);
            //in dengan qty lama
            $stock_card = new MStockCard;
            $stock_card->setConnection(Auth::user()->db_name);
            $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
            $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
            $stock_card->mstockcarddate = Carbon::parse($request->date);
            $stock_card->mstockcardtranstype = $request->type;
            $stock_card->mstockcardtransno = $header->mhinvoiceno;
            $stock_card->mstockcardremark = "Revisi Transaksi Hapus item".$request->type." untuk ".$customer->mcustomername;
            $stock_card->mstockcardstockin = $v->mdinvoicegoodsqty;
            $stock_card->mstockcardstockout = 0;
            $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock + $v->mdinvoicegoodsqty;
            $stock_card->mstockcardwhouse = $g['warehouse'];
            $stock_card->mstockcarduserid = Auth::user()->id;
            $stock_card->mstockcardusername = Auth::user()->name;
            $stock_card->mstockcardeventdate = Carbon::now();
            $stock_card->mstockcardeventtime = Carbon::now();
            $stock_card->save();
            // $mgoods->mgoodsstock = $stock_card->mstockcardstocktotal;
            // $mgoods->save();

            IntegrityHelper::restoreCOGS($mgoods,$invoice_detail->mhinvoiceno,$v->mdinvoicegoodsqty,"hapus detail.");
        }

        $journal_hpp->mjournaldebit = $sum_hpp_journal;
        $journal_persediaan->mjournalcredit = $sum_persediaan_journal;

        $journal_hpp->save();
        $journal_persediaan->save();

        DB::connection(Auth::user()->db_name)->commit();
        $resp = [
            'status' => 'ok',
            'data' => $invoice_header
        ];
        return $resp;
      } catch(Exception $e){
        DB::connection(Auth::user()->db_name)->rollBack();
        $resp = [
            'status' => 'err',
            'data' => $e
        ];
        return $resp;
      }

    }

    public static function void_transaction($id){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{
            $header = MHInvoice::on(Auth::user()->db_name)->where('id',$id)->first();
            $header->void = 1;
            $header->save();

            $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();

            $journals = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhinvoiceno)->get();
            $coa_piutang = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msyspayaraccount)->first();
            $coa_sales = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccinv)->first();
            $coa_tax = MCOA::on(Auth::user()->db_name)->where('mcoacode','2102.01')->first();
            $coa_hpp = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccsellingexpense)->first();
            $coa_persediaan_barang = MCOA::on(Auth::user()->db_name)->where('mcoacode',$conf->msysaccstock)->first();

            $journal_hpp = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhinvoiceno)->where('mjournalcoa',$conf->msysaccsellingexpense)->first();
            $journal_persediaan = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhinvoiceno)->where('mjournalcoa',$conf->msysaccstock)->first();

            $coa_piutang->update_saldo('-',$header->mhinvoicegrandtotal);
            $coa_sales->update_saldo('-',$header->mhinvoicesubtotal);
            $coa_tax->update_saldo('-',$header->mhinvoicetaxtotal);
            $coa_hpp->update_saldo('+',$journal_hpp->mjournaldebit);
            $coa_persediaan_barang->update_saldo('+',$journal_persediaan->mjournalcredit);

            $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$header->mhinvoiceno)->get();
            MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhinvoiceno)->delete();
            // void all details and return the stock
            foreach($details as $detail){

                $detail->void = 1;
                $detail->save();

                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$detail->mdinvoicegoodsid)->first();
                $stock_ref = MStockCard::on(Auth::user()->db_name)->where('mstockcardtransno',$header->mhinvoiceno)->first();

                // create deletion stock
                $stock_card = new MStockCard;
                $stock_card->setConnection(Auth::user()->db_name);
                $stock_card->mstockcardgoodsid = $stock_ref->mstockcardgoodsid;
                $stock_card->mstockcardgoodsname = $stock_ref->mstockcardgoodsname;
                $stock_card->mstockcarddate = Carbon::now();
                $stock_card->mstockcardtranstype = 'Pembatalan transaksi';
                $stock_card->mstockcardtransno = $header->mhinvoiceno;
                $stock_card->mstockcardremark = "Pembatalan transaksi oleh ".Auth::user()->name."/".Auth::user()->id;
                $stock_card->mstockcardstockout = 0;
                $stock_card->mstockcardstockin = $stock_ref->mstockcardstockout;
                $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock += $stock_ref->mstockcardstockout;
                $stock_card->mstockcardwhouse = $stock_ref->mstockcardwhouse;
                $stock_card->mstockcarduserid = Auth::user()->id;
                $stock_card->mstockcardusername = Auth::user()->name;
                $stock_card->mstockcardeventdate = Carbon::now();
                $stock_card->mstockcardeventtime = Carbon::now();
                $stock_card->edited = 0;
                $stock_card->save();

                // update goods stock
                // $last_stock = $mgoods->mgoodsstock;
                // $last_stock += $stock_card->mstockcardstockin;
                // $mgoods->mgoodsstock = $last_stock;
                $mgoods->save();

                IntegrityHelper::restoreCOGS($mgoods,$header->mhinvoiceno,$stock_ref->mstockcardstockout);
            }

            // void ar
            $ars = MARCard::on(Auth::user()->db_name)->where('marcardtransno',$header->mhinvoiceno)->get();
            foreach($ars as $ar){
                $ar->void = 1;
                $ar->save();
            }

            foreach($journals as $j){
                $j->void = 1;
                $j->save();
            }

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';

        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            dd($e);
            return 'err';
        }
    }

    //relation

    public function customers(){
      return MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$this->mhinvoicecustomerid)->first();
    }

    public function details(){
        return MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$this->mhinvoiceno)->get();
    }
}
