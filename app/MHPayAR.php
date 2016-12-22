<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MConfig;
use App\MCustomer;
use Carbon\Carbon;
use Auth;
use DB;
use App\Helper\DBHelper;

class MHPayAR extends Model
{
    protected $table = "mhpayar";
    protected static function boot(){
  		parent::boot();
  		static::addGlobalScope('actives', function(Builder $builder) {
  				$builder->where('void', '=', 0);
                $builder->orderBy('mhpayardate','desc');
  		});
      static::created(function($mhpayar){
        $mhpayar->update_prefix_status();
      });
  	}

    public function update_prefix_status(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixpayarcount = $conf->msysprefixpayarcount+1;
      $conf->msysprefixpayarlastcount = $conf->get_last_count_format($conf->msysprefixpayarcount);
      $conf->save();
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      try{
        DBHelper::configureConnection(Auth::user()->db_alias);
        DB::connection(Auth::user()->db_name)->select(DB::raw('call autogen("mhpayar","'.$conf->msysprefixpayar.'",'.$conf->msysprefixpayarcount.',"mhpayarno",'.$this->id.')'));
      } catch(Exception $e){
        var_dump($e);
        return $e;
      }
    }

    public static function start_transaction($request){
      DB::connection(Auth::user()->db_name)->beginTransaction();
      try{

          $header = new MHPayAR;
          $header->setConnection(Auth::user()->db_name);
          $header->mhpayarno = "";
          $header->mhpayarcustomerno = MCustomer::on(Auth::user()->db_name)->where('id',$request->invoice_customer)->first()->mcustomerid;
          $header->mhpayarcustomername = MCustomer::on(Auth::user()->db_name)->where('id',$request->invoice_customer)->first()->mcustomername;
          $header->mhpayardate = Carbon::parse($request->invoice_date);
          $header->mhpayarbank = $request->invoice_bank;
          $header->mhpayarrefno = $request->invoice_ref_no;
          $header->mhpayarcheckno = $request->invoice_check_no;
          $header->mhpayarpayamount = $request->total_pay;
          $header->mhpayarsubtotal = $request->total_invoice;
          $header->mhpayardiscounttotal = $request->discount;
          $header->mhpayargrandtotal = $request->total_pay - $request->discount;
          $header->mhpayarremarks = "";
          $header->void = 0;
          $header->save();

          if($request->invoice_auto == true){
              $header->autogenproc();
          } else {
              $header->mhpayapno = $request->no;
          }

          $header = MHPayAR::on(Auth::user()->db_name)->where('id',$header->id)->first();

          foreach($request->ars as $ar){

              $old_ar = MARCard::on(Auth::user()->db_name)->where('id',$ar['id'])->first();

              $detail = new MDPayAR;
              $detail->setConnection(Auth::user()->db_name);
              $detail->mhpayarno = $header->mhpayarno;
              $detail->mdpayartransno = $old_ar->marcardtransno;
              $detail->mdpayarinvoicetotal = $ar['marcardtotalinv'];
              $detail->mdpayarinvoicedate = $header->mhpayardate;
              $detail->mdpayarinvoiceoutstanding = $ar['marcardoutstanding'];
              $detail->mdpayarinvoicepayamount = $ar['payamount'];
              $detail->mdpayarinvoicediscount = 0;
              $detail->mdpayaruserid = Auth::user()->id;
              $detail->mdpayarusername = Auth::user()->name;
              $detail->mdpayareventdate = Carbon::now();
              $detail->mdpayareventtime = Carbon::now();
              $detail->save();

              $new_ar = new MARCard;
              $new_ar->setConnection(Auth::user()->db_name);
              $new_ar->marcardcustomerid = $header->mhpayarcustomerno;
              $new_ar->marcardcustomername = $header->mhpayarcustomername;
              $new_ar->marcarddate = Carbon::now();
              $new_ar->marcardtransno = $old_ar->marcardtransno;
              $new_ar->marcardpayno = $header->mhpayarno;
              $new_ar->marcardremark = "Pembayaran Hutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
              $new_ar->marcardduedate = $old_ar->marcardduedate;
              $new_ar->marcardtotalinv = $old_ar->marcardtotalinv;
              $new_ar->marcardpayamount = $ar['payamount'];
              $new_ar->marcardoutstanding = $old_ar->marcardoutstanding - $ar['payamount'];
              $new_ar->marcardusername = Auth::user()->name;
              $new_ar->marcarduserid = Auth::user()->id;
              $new_ar->marcardusereventdate = Carbon::now();
              $new_ar->marcardusereventtime = Carbon::now();
              $new_ar->void = 0;
              $new_ar->save();

              $detail->mdpayar_arref = $new_ar->id;
              $detail->save();
          }

          DB::connection(Auth::user()->db_name)->commit();
          return "ok";
      } catch(\Exception $e){
          DB::connection(Auth::user()->db_name)->rollBack();
          var_dump($e);
          return "err";
      }

    }
}
