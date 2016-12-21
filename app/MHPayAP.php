<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MConfig;
use App\MSupplier;
use Carbon\Carbon;
use Auth;
use DB;
use App\Helper\DBHelper;

class MHPayAP extends Model
{
    protected $table = "mhpayap";
    protected static function boot(){
  		parent::boot();
  		static::addGlobalScope('actives', function(Builder $builder) {
  				$builder->where('void', '=', 0);
                $builder->orderBy('mhpayapdate','desc');
  		});
      static::created(function($mhpurchase){
        $mhpurchase->update_prefix_status();
      });
  	}

    public function update_prefix_status(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixpayapcount = $conf->msysprefixpayapcount+1;
      $conf->msysprefixpayaplastcount = $conf->get_last_count_format($conf->msysprefixpayapcount);
      $conf->save();
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      try{
        DBHelper::configureConnection(Auth::user()->db_alias);
        DB::connection(Auth::user()->db_name)->select(DB::raw('call autogen("mhpayap","'.$conf->msysprefixpayap.'",'.$conf->msysprefixpayapcount.',"mhpayapno",'.$this->id.')'));
      } catch(Exception $e){
        var_dump($e);
        return $e;
      }
    }

    public static function start_transaction($request){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{

            $header = new MHPayAP;
            $header->setConnection(Auth::user()->db_name);
            $header->mhpayapno = "";
            $header->mhpayapsupplierno = MSupplier::on(Auth::user()->db_name)->where('id',$request->invoice_supplier)->first()->msupplierid;
            $header->mhpayapsuppliername = MSupplier::on(Auth::user()->db_name)->where('id',$request->invoice_supplier)->first()->msuppliername;
            $header->mhpayapdate = Carbon::parse($request->invoice_date);
            $header->mhpayapbank = $request->invoice_bank;
            $header->mhpayaprefno = $request->invoice_ref_no;
            $header->mhpayapcheckno = $request->invoice_check_no;
            $header->mhpayappayamount = $request->total_pay;
            $header->mhpayapsubtotal = $request->total_invoice;
            $header->mhpayapdiscounttotal = $request->discount;
            $header->mhpayapgrandtotal = $request->total_pay - $request->discount;
            $header->mhpayapremarks = "";
            $header->void = 0;
            $header->save();

            if($request->invoice_auto == true){
                $header->autogenproc();
            } else {
                $header->mhpayapno = $request->no;
            }

            $header = MHPayAp::on(Auth::user()->db_name)->where('id',$header->id)->first();

            foreach($request->aps as $ap){

                $detail = new MDPayAp;
                $detail->setConnection(Auth::user()->db_name);
                $detail->mhpayapno = $header->mhpayapno;
                $detail->mdpayapinvoicedate = $header->mhpayapdate;
                $detail->mdpayapinvoiceoutstanding = $ap['mapcardoutstanding'];
                $detail->mdpayapinvoicepayamount = $ap['payamount'];
                $detail->mdpayapinvoicediscount = 0;
                $detail->mdpayapuserid = Auth::user()->id;
                $detail->mdpayapusername = Auth::user()->name;
                $detail->mdpayapeventdate = Carbon::now();
                $detail->mdpayapeventtime = Carbon::now();
                $detail->save();

                $old_ap = MAPCard::on(Auth::user()->db_name)->where('id',$ap['id'])->first();

                $new_ap = new MAPCard;
                $new_ap->setConnection(Auth::user()->db_name);
                $new_ap->mapcardsupplierid = $header->mhpayapsupplierno;
                $new_ap->mapcardsuppliername = $header->mhpayapsuppliername;
                $new_ap->mapcardtdate = Carbon::now();
                $new_ap->mapcardtransno = $old_ap->mapcardtransno;
                $new_ap->mapcardpayno = $header->mhpayapno;
                $new_ap->mapcardremark = "Pembayaran Hutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
                $new_ap->mapcardduedate = $old_ap->mapcardduedate;
                $new_ap->mapcardtotalinv = $old_ap->mapcardtotalinv;
                $new_ap->mapcardpayamount = $ap['payamount'];
                $new_ap->mapcardoutstanding = $old_ap->mapcardoutstanding - $ap['payamount'];
                $new_ap->mapcardusername = Auth::user()->name;
                $new_ap->mapcarduserid = Auth::user()->id;
                $new_ap->mapcardeventdate = Carbon::now();
                $new_ap->mapcardeventtime = Carbon::now();
                $new_ap->void = 0;
                $new_ap->save();
            }

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            var_dump($e);
            return "err";
        }
    }
}
