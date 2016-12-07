<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MConfig;
use Auth;
use App\Helper\DBHelper;
use Carbon\Carbon;
use App\MCUSTOMER;
use App\MStockCard;
use App\MARCard;
use DB;
use Exception;

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

    public static function start_transaction($request){
      $allow_minus = MConfig::on(Auth::user()->db_name)->where('id',1)->first()->msysinventallowminus;
      DB::connection(Auth::user()->db_name)->beginTransaction();
      try{
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
          $invoice_detail->save();

          //update stock card
          $stock_card = new MStockCard;
          $stock_card->setConnection(Auth::user()->db_name);
          $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
          $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
          $stock_card->mstockcarddate = Carbon::parse($request->date);
          $stock_card->mstockcardtranstype = $request->type;
          $stock_card->mstockcardtransno = $header->mhinvoiceno;
          $stock_card->mstockcardremark = "Transaksi ".$request->type." untuk ".$customer->mcustomername;
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
          $stock_card->mstockcardunit3 = $mgoods->mgoodscurrentunit3;
          $stock_card->mstockcardunit3conv = $mgoods->mgoodscurrentunit3conv;
          $stock_card->mstockcardunit3label = $mgoods->mgoodscurrentunit3label;
          $stock_card->mstockcardunit2 = $mgoods->mgoodscurrentunit2;
          $stock_card->mstockcardunit2conv = $mgoods->mgoodscurrentunit2conv;
          $stock_card->mstockcardunit2label = $mgoods->mgoodscurrentunit2label;
          $stock_card->mstockcardunit1 = $mgoods->mgoodscurrentunit1;
          $stock_card->mstockcardunit1conv = $mgoods->mgoodscurrentunit1conv;
          $stock_card->mstockcardunit1label = $mgoods->mgoodscurrentunit1label;
          // out conversion
          $stock_card->mstockcardoutunit3 = $g['detail_goods_unit3'];
          $stock_card->mstockcardoutunit3conv = $g['detail_goods_unit3_conv'];
          $stock_card->mstockcardoutunit3label = $g['detail_goods_unit3_label'];
          $stock_card->mstockcardoutunit2 = $g['detail_goods_unit2'];
          $stock_card->mstockcardoutunit2conv = $g['detail_goods_unit2_conv'];
          $stock_card->mstockcardoutunit2label = $g['detail_goods_unit2_label'];
          $stock_card->mstockcardoutunit1 = $g['detail_goods_unit1'];
          $stock_card->mstockcardoutunit1conv = $g['detail_goods_unit1_conv'];
          $stock_card->mstockcardoutunit1label = $g['detail_goods_unit1_label'];
          $stock_card->save();

          // update master barang
        //   $mgoods->mgoodsstock = $stock_card->mstockcardstocktotal;
          $mgoods->mgoodsstock = $mgoods->mgoodsstock - $g['usage'];
          $mgoods->mgoodscurrentunit3 -= $g['detail_goods_unit3'];
          $mgoods->mgoodscurrentunit3conv = $g['detail_goods_unit3_conv'];
          $mgoods->mgoodscurrentunit3label = $g['detail_goods_unit3_label'];
          $mgoods->mgoodscurrentunit2 -= $g['detail_goods_unit2'];
          $mgoods->mgoodscurrentunit2conv = $g['detail_goods_unit2_conv'];
          $mgoods->mgoodscurrentunit2label = $g['detail_goods_unit2_label'];
          $mgoods->mgoodscurrentunit1 -= $g['detail_goods_unit1'];
          $mgoods->mgoodscurrentunit1conv = $g['detail_goods_unit1_conv'];
          $mgoods->mgoodscurrentunit1label = $g['detail_goods_unit1_label'];
          $mgoods->save();

          //check allow minus
          if($allow_minus == 0 && ($mgoods->mgoodsstock < 0)){
            DB::connection(Auth::user()->db_name)->rollBack();
            return 'empty';
          }

        }

        // update AR table

        $ar = new MARCard;
        $ar->setConnection(Auth::user()->db_name);
        $ar->marcardcustomerid = $customer->mcustomerid;
        $ar->marcardcustomername = $customer->mcustomername;
        $ar->marcarddate = Carbon::now();
        $ar->marcardtranstype = $request->type;
        $ar->marcardtransno = $header->mhinvoiceno;
        $ar->marcardremark = "Transaksi ".$request->type." untuk ".$customer->mcustomername;
        $ar->marcardduedate = Carbon::now()->addDays($customer->mcustomerdefaultar);
        $ar->marcardtotalinv = $request->subtotal + $request->tax - $request->disc;
        $ar->marcardpayamount = 0;
        $ar->marcardoutstanding = $request->subtotal + $request->tax - $request->disc;
        $ar->marcarduserid = Auth::user()->id;
        $ar->marcardusername = Auth::user()->name;
        $ar->marcardusereventdate = Carbon::now();
        $ar->marcardusereventtime = Carbon::now();
        $ar->save();

        DB::connection(Auth::user()->db_name)->commit();
        return 'ok';
      } catch(Exception $e){
        DB::connection(Auth::user()->db_name)->rollBack();
        return 'err';
      }

    }

    public function update_transaction($request){
      $allow_minus = MConfig::on(Auth::user()->db_name)->where('id',1)->first()->msysinventallowminus;
      DB::connection(Auth::user()->db_name)->beginTransaction();
      try{
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

        // void all detail dlu biar tau mana yg di hapus
        $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$invoice_header->mhinvoiceno)->get();
        foreach ($details as $dt) {
          $dt->void = 1;
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
              $invoice_detail->mdinvoicegoodsidwhouse = $g['warehouse'];
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
                $stock_card->mstockcardremark = "Revisi Transaksi ".$request->type." untuk ".$customer->mcustomername;
                $stock_card->mstockcardstockin = $old_qty;
                $stock_card->mstockcardstockout = 0;
                $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
                $stock_card->mstockcardwhouse = $g['warehouse'];
                $stock_card->mstockcarduserid = Auth::user()->id;
                $stock_card->mstockcardusername = Auth::user()->name;
                $stock_card->mstockcardeventdate = Carbon::now();
                $stock_card->mstockcardeventtime = Carbon::now();
                $stock_card->edited = 1;
                $stock_card->void = 0;
                // in conversion
                $stock_card->mstockcardinunit3 += $last_stock->mstockcardoutunit3;
                $stock_card->mstockcardinunit3conv = $last_stock->mstockcardoutunit3conv;
                $stock_card->mstockcardinunit3label = $last_stock->mstockcardoutunit3label;
                $stock_card->mstockcardinunit2 += $last_stock->mstockcardoutunit2;
                $stock_card->mstockcardinunit2conv = $last_stock->mstockcardoutunit2conv;
                $stock_card->mstockcardinunit2label = $last_stock->mstockcardoutunit2label;
                $stock_card->mstockcardinunit1 += $last_stock->mstockcardoutunit1;
                $stock_card->mstockcardinunit1conv = $last_stock->mstockcardoutunit1conv;
                $stock_card->mstockcardinunit1label = $last_stock->mstockcardoutunit1label;
                $stock_card->save();

                if($old_qty != $g['usage']){
                    $mgoods->mgoodsstock += $last_stock->mstockcardstockout;
                    $mgoods->mgoodscurrentunit3 += $last_stock->mstockcardoutunit3;
                    $mgoods->mgoodscurrentunit3conv = $last_stock->mstockcardoutunit3conv;
                    $mgoods->mgoodscurrentunit3label = $last_stock->mstockcardoutunit3label;
                    $mgoods->mgoodscurrentunit2 += $last_stock->mstockcardoutunit2;
                    $mgoods->mgoodscurrentunit2conv = $last_stock->mstockcardoutunit2conv;
                    $mgoods->mgoodscurrentunit2label = $last_stock->mstockcardoutunit2label;
                    $mgoods->mgoodscurrentunit1 += $last_stock->mstockcardoutunit1;
                    $mgoods->mgoodscurrentunit1conv = $last_stock->mstockcardoutunit1conv;
                    $mgoods->mgoodscurrentunit1label = $last_stock->mstockcardoutunit1label;
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
                $stock_card->mstockcardremark = "Editing Transaksi ".$request->type." untuk ".$customer->mcustomername;
                $stock_card->mstockcardstockin = 0;
                $stock_card->mstockcardstockout = $g['usage'];
                $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
                $stock_card->mstockcardwhouse = $g['warehouse'];
                $stock_card->mstockcarduserid = Auth::user()->id;
                $stock_card->mstockcardusername = Auth::user()->name;
                $stock_card->mstockcardeventdate = Carbon::now();
                $stock_card->mstockcardeventtime = Carbon::now();
                $stock_card->mstockcardunit3 = $mgoods->mgoodscurrentunit3;
                $stock_card->mstockcardunit3conv = $mgoods->mgoodscurrentunit3conv;
                $stock_card->mstockcardunit3label = $mgoods->mgoodscurrentunit3label;
                $stock_card->mstockcardunit2 = $mgoods->mgoodscurrentunit2;
                $stock_card->mstockcardunit2conv = $mgoods->mgoodscurrentunit2conv;
                $stock_card->mstockcardunit2label = $mgoods->mgoodscurrentunit2label;
                $stock_card->mstockcardunit1 = $mgoods->mgoodscurrentunit1;
                $stock_card->mstockcardunit1conv = $mgoods->mgoodscurrentunit1conv;
                $stock_card->mstockcardunit1label = $mgoods->mgoodscurrentunit1label;
                $stock_card->edited = 1;
                $stock_card->void = 0;
                // out conversion
                $stock_card->mstockcardoutunit3 = $g['detail_goods_unit3'];
                $stock_card->mstockcardoutunit3conv = $g['detail_goods_unit3_conv'];
                $stock_card->mstockcardoutunit3label = $g['detail_goods_unit3_label'];
                $stock_card->mstockcardoutunit2 = $g['detail_goods_unit2'];
                $stock_card->mstockcardoutunit2conv = $g['detail_goods_unit2_conv'];
                $stock_card->mstockcardoutunit2label = $g['detail_goods_unit2_label'];
                $stock_card->mstockcardoutunit1 = $g['detail_goods_unit1'];
                $stock_card->mstockcardoutunit1conv = $g['detail_goods_unit1_conv'];
                $stock_card->mstockcardoutunit1label = $g['detail_goods_unit1_label'];
                $stock_card->save();

                $mgoods->mgoodsstock -= $g['usage'];
                $mgoods->mgoodscurrentunit3 -= $g['detail_goods_unit3'];
                $mgoods->mgoodscurrentunit3conv = $g['detail_goods_unit3_conv'];
                $mgoods->mgoodscurrentunit3label = $g['detail_goods_unit3_label'];
                $mgoods->mgoodscurrentunit2 -= $g['detail_goods_unit2'];
                $mgoods->mgoodscurrentunit2conv = $g['detail_goods_unit2_conv'];
                $mgoods->mgoodscurrentunit2label = $g['detail_goods_unit2_label'];
                $mgoods->mgoodscurrentunit1 -= $g['detail_goods_unit1'];
                $mgoods->mgoodscurrentunit1conv = $g['detail_goods_unit1_conv'];
                $mgoods->mgoodscurrentunit1label = $g['detail_goods_unit1_label'];
                $mgoods->save();

                //check allow minus
                if($allow_minus == 0 && ($mgoods->mgoodsstock < 0)){
                  DB::connection(Auth::user()->db_name)->rollBack();
                  return 'empty';
                }

              } else {
                // data tdk berubah
                // $invoice_detail = MDInvoice::on(Auth::user()->db_name)->where('mdinvoicegoodsid',$g['goods']['mgoodscode'])->where('mhinvoiceno',$header->mhinvoiceno)->first();
                $invoice_detail->void=0;
                $invoice_detail->save();
              }
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
              $stock_card->mstockcardremark = "Transaksi ".$request->type." untuk ".$customer->mcustomername;
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
              $stock_card->mstockcardunit3 = $mgoods->mgoodscurrentunit3;
              $stock_card->mstockcardunit3conv = $mgoods->mgoodscurrentunit3conv;
              $stock_card->mstockcardunit3label = $mgoods->mgoodscurrentunit3label;
              $stock_card->mstockcardunit2 = $mgoods->mgoodscurrentunit2;
              $stock_card->mstockcardunit2conv = $mgoods->mgoodscurrentunit2conv;
              $stock_card->mstockcardunit2label = $mgoods->mgoodscurrentunit2label;
              $stock_card->mstockcardunit1 = $mgoods->mgoodscurrentunit1;
              $stock_card->mstockcardunit1conv = $mgoods->mgoodscurrentunit1conv;
              $stock_card->mstockcardunit1label = $mgoods->mgoodscurrentunit1label;
              // out conversion
              $stock_card->mstockcardoutunit3 = $g['detail_goods_unit3'];
              $stock_card->mstockcardoutunit3conv = $g['detail_goods_unit3_conv'];
              $stock_card->mstockcardoutunit3label = $g['detail_goods_unit3_label'];
              $stock_card->mstockcardoutunit2 = $g['detail_goods_unit2'];
              $stock_card->mstockcardoutunit2conv = $g['detail_goods_unit2_conv'];
              $stock_card->mstockcardoutunit2label = $g['detail_goods_unit2_label'];
              $stock_card->mstockcardoutunit1 = $g['detail_goods_unit1'];
              $stock_card->mstockcardoutunit1conv = $g['detail_goods_unit1_conv'];
              $stock_card->mstockcardoutunit1label = $g['detail_goods_unit1_label'];
              $stock_card->save();

              // update master barang
            //   $mgoods->mgoodsstock = $stock_card->mstockcardstocktotal;
              $mgoods->mgoodsstock = $mgoods->mgoodsstock - $g['usage'];
              $mgoods->mgoodscurrentunit3 -= $g['detail_goods_unit3'];
              $mgoods->mgoodscurrentunit3conv = $g['detail_goods_unit3_conv'];
              $mgoods->mgoodscurrentunit3label = $g['detail_goods_unit3_label'];
              $mgoods->mgoodscurrentunit2 -= $g['detail_goods_unit2'];
              $mgoods->mgoodscurrentunit2conv = $g['detail_goods_unit2_conv'];
              $mgoods->mgoodscurrentunit2label = $g['detail_goods_unit2_label'];
              $mgoods->mgoodscurrentunit1 -= $g['detail_goods_unit1'];
              $mgoods->mgoodscurrentunit1conv = $g['detail_goods_unit1_conv'];
              $mgoods->mgoodscurrentunit1label = $g['detail_goods_unit1_label'];
              $mgoods->save();

              //check allow minus
              if($allow_minus == 0 && ($mgoods->mgoodsstock < 0)){
                DB::connection(Auth::user()->db_name)->rollBack();
                return 'empty';
              }
          }

        }

        // update AR
        $ar = MARCard::on(Auth::user()->db_name)->where('marcardcustomerid',$header->mhinvoicecustomerid)->where('marcardtransno',$header->mhinvoiceno)->first();
        $ar->marcardcustomerid = $customer->mcustomerid;
        $ar->marcardcustomername = $customer->mcustomername;
        $ar->marcarddate = Carbon::now();
        $ar->marcardtranstype = $request->type;
        $ar->marcardtransno = $header->mhinvoiceno;
        $ar->marcardremark = "Edit Transaksi ".$request->type." untuk ".$customer->mcustomername;
        $ar->marcardduedate = Carbon::now()->addDays($customer->mcustomerdefaultar);
        $ar->marcardtotalinv = $request->subtotal + $request->tax - $request->disc;
        $ar->marcardpayamount = 0;
        $ar->marcardoutstanding = $request->subtotal + $request->tax - $request->disc;
        $ar->marcarduserid = Auth::user()->id;
        $ar->marcardusername = Auth::user()->name;
        $ar->marcardusereventdate = Carbon::now();
        $ar->marcardusereventtime = Carbon::now();
        $ar->save();

        //voided details
        $voided_details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$invoice_header->mhinvoiceno)->where('void',1)->get();
        foreach ($voided_details as $v) {
            $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$v->mdinvoicegoodsid)->first();
            //in dengan qty lama
            $stock_card = new MStockCard;
            $stock_card->setConnection(Auth::user()->db_name);
            $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
            $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
            $stock_card->mstockcarddate = Carbon::parse($request->date);
            $stock_card->mstockcardtranstype = $request->type;
            $stock_card->mstockcardtransno = $header->mhinvoiceno;
            $stock_card->mstockcardremark = "Editing Transaksi Hapus item".$request->type." untuk ".$customer->mcustomername;
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
        }

        DB::connection(Auth::user()->db_name)->commit();
        return 'ok';
      } catch(Exception $e){
        DB::connection(Auth::user()->db_name)->rollBack();
        return $e;
      }

    }

    public function void_transaction(){
      $details = MDInvoice::on(Auth::user()->db_name)->where('mhinvoiceno',$this->mhinvoiceno)->get();
      foreach($details as $d){
        $d->void = 1;
        $d->save();

        // return the stock
        $old_stock = MStockCard::on(Auth::user()->db_name)->where('mstockcardgoodsid',$d->mdinvoicegoodsid)->first();

        $stock_card = new MStockCard;
        $stock_card->setConnection(Auth::user()->db_name);
        $stock_card->mstockcardgoodsid = $old_stock->mstockcardgoodsid;
        $stock_card->mstockcardgoodsname = $old_stock->mstockcardgoodsname;
        $stock_card->mstockcarddate = $old_stock->mstockcarddate;
        $stock_card->mstockcardtranstype = $old_stock->mstockcardtranstype;
        $stock_card->mstockcardtransno = $old_stock->mstockcardtransno;
        $stock_card->mstockcardremark = "Pembatalan Transaksi ".$old_stock->mstockcardtranstype;
        // yg in adalah yg out sebelumnya
        $stock_card->mstockcardstockin = $old_stock->mstockcardstockout;
        $stock_card->mstockcardstockout = 0;
        $stock_card->mstockcardwhouse = 1;
        $stock_card->mstockcarduserid = Auth::user()->id;
        $stock_card->mstockcardusername = Auth::user()->name;
        $stock_card->mstockcardeventdate = Carbon::now();
        $stock_card->mstockcardeventtime = Carbon::now();
        $stock_card->save();

      }

      $this->void = 1;
      $this->save();
    }

    //relation

    public function customers(){
      return MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$this->mhinvoicecustomerid)->first();
    }
}
