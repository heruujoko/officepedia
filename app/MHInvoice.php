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
        $customer = MCUSTOMER::on(Auth::user()->db_name)->where('mcustomerid',$request->mcustomerid)->first();
        $invoice_header->mhinvoicecustomerid = $customer->mcustomerid;
        $invoice_header->mhinvoicecustomername = $customer->mcustomername;
        $invoice_header->save();
        $header = MHInvoice::on(Auth::user()->db_name)->where('id',$invoice_header->id)->first();

        //insert detail
        foreach($request->goods as $g){
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
          $stock_card->mstockcardtranstype = "PEMBELIAN masih manual";
          $stock_card->mstockcardtransno = $header->mhinvoiceno;
          $stock_card->mstockcardremark = "Keterangan otomatis";
          $stock_card->mstockcardstockin = 0;
          $stock_card->mstockcardstockout = $g['usage'];
          $stock_card->mstockcardwhouse = 1;
          $stock_card->mstockcarduserid = Auth::user()->id;
          $stock_card->mstockcardusername = Auth::user()->name;
          $stock_card->mstockcardeventdate = Carbon::now();
          $stock_card->mstockcardeventtime = Carbon::now();
          $stock_card->save();
        }

        // kurang AR table

        DB::connection(Auth::user()->db_name)->commit();
        return true;
      } catch(Exception $e){
        DB::connection(Auth::user()->db_name)->rollBack();
        return $e;
      }

    }
}
