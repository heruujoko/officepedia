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
  		});
      static::created(function($mhinvoice){
        $mhinvoice->update_prefix_status();
        $mhinvoice->autogenproc();
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
      DB::connection(Auth::user()->db_name)->beginTransaction();
      try{
        //insert header
        $invoice_header = new MHInvoice;
        $invoice_header->setConnection(Auth::user()->db_name);
        $invoice_header->mhinvoicedate = Carbon::parse($request->date);
        $invoice_header->mhinvoicesubtotal = $request->subtotal;
        $invoice_header->mhinvoicetaxtotal = $request->tax;
        $invoice_header->mhinvoicediscounttotal = $request->discount;
        $invoice_header->mhinvoicegrandtotal = $request->subtotal + $request->tax - $request->disc;
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

        //insert detail
        foreach($request->goods as $g){

          $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g['goods']['mgoodscode'])->first();

          $invoice_detail = new MDInvoice;
          $invoice_detail->setConnection(Auth::user()->db_name);
          $invoice_detail->mhinvoiceno = $header->mhinvoiceno;
          $invoice_detail->mdcustomerid = $customer->mcustomerid;
          $invoice_detail->mdcustomername = $customer->mcustomername;
          $invoice_detail->mdinvoicedate = $header->mhinvoicedate;
          $invoice_detail->mdinvoicegoodsid = $g['goods']['mgoodscode'];
          $invoice_detail->mdinvoicegoodsname = $g['goods']['mgoodsname'];
          $invoice_detail->mdinvoicegoodsqty = $g['usage'];
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
          $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock - $g['usage'];
          $stock_card->mstockcardwhouse = $g['warehouse'];
          $stock_card->mstockcarduserid = Auth::user()->id;
          $stock_card->mstockcardusername = Auth::user()->name;
          $stock_card->mstockcardeventdate = Carbon::now();
          $stock_card->mstockcardeventtime = Carbon::now();
          $stock_card->save();

          // update master barang

          $mgoods->mgoodsstock = $stock_card->mstockcardstocktotal;
          $mgoods->save();
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
        $ar->marcardoutstanding = 0;
        $ar->marcarduserid = Auth::user()->id;
        $ar->marcardusername = Auth::user()->name;
        $ar->marcardusereventdate = Carbon::now();
        $ar->marcardusereventtime = Carbon::now();
        $ar->save();

        DB::connection(Auth::user()->db_name)->commit();
        return true;
      } catch(Exception $e){
        DB::connection(Auth::user()->db_name)->rollBack();
        return false;
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
}
