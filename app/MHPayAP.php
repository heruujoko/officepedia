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
use App\MJournal;
use App\MCOA;

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

            $header = MHPayAP::on(Auth::user()->db_name)->where('id',$header->id)->first();
            $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            $coa = $conf->msyspayapaccount;
            $coa_bank = MCOA::on(Auth::user()->db_name)->where('id',$header->mhpayapbank)->first()->mcoacode;

            foreach($request->aps as $ap){

                $old_ap = MAPCard::on(Auth::user()->db_name)->where('id',$ap['id'])->first();

                $detail = new MDPayAP;
                $detail->setConnection(Auth::user()->db_name);
                $detail->mhpayapno = $header->mhpayapno;
                $detail->mdpayaptransno = $old_ap->mapcardtransno;
                $detail->mdpayapinvoicetotal = $ap['mapcardtotalinv'];
                $detail->mdpayapinvoicedate = $header->mhpayapdate;
                $detail->mdpayapinvoiceoutstanding = $ap['mapcardoutstanding'];
                $detail->mdpayapinvoicepayamount = $ap['payamount'];
                $detail->mdpayapinvoicediscount = 0;
                $detail->mdpayapuserid = Auth::user()->id;
                $detail->mdpayapusername = Auth::user()->name;
                $detail->mdpayapeventdate = Carbon::now();
                $detail->mdpayapeventtime = Carbon::now();
                $detail->save();

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

                $detail->mdpayap_apref = $new_ap->id;
                $detail->save();

                $last_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$detail->mdpayaptransno)->where('mjournaltranstype','Pembelian')->first();
                $debit = $last_journal->mjournaldebit - $detail->mdpayapinvoicepayamount;
                $credit = $detail->mdpayapinvoicepayamount;
                MJournal::record_journal($header->mhpayapno,'Pembayaran Hutang',$coa,$debit,0,"");
                MJournal::record_journal($header->mhpayapno,'Pembayaran Hutang',$coa_bank,0,$credit,"");

            }

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return "err";
        }
    }

    public function update_transaction($request){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{

            $header = MHPayAP::on(Auth::user()->db_name)->where('id',$this->id)->first();
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

            $details = MDPayAP::on(Auth::user()->db_name)->where('mhpayapno',$header->mhpayapno)->get();
            foreach ($details as $d) {
                $d->void = 1;
                $d->save();
            }

            $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            $coa = $conf->msyspayapaccount;
            $coa_bank = MCOA::on(Auth::user()->db_name)->where('id',$header->mhpayapbank)->first()->mcoacode;

            foreach ($request->aps as $ap) {

                $old_ap = MAPCard::on(Auth::user()->db_name)->where('id',$ap['mdpayap_apref'])->first();

                $detail = MDPayAP::on(Auth::user()->db_name)->where('mhpayapno',$header->mhpayapno)->where('mdpayaptransno',$ap['mdpayaptransno'])->first();

                $last_pay = $detail->mdpayapinvoicepayamount;

                $detail->mhpayapno = $header->mhpayapno;
                $detail->mdpayaptransno = $old_ap->mapcardtransno;
                $detail->mdpayapinvoicetotal = $ap['mapcardtotalinv'];
                $detail->mdpayapinvoicedate = $header->mhpayapdate;
                $detail->mdpayapinvoiceoutstanding = $ap['mapcardoutstanding'];
                $detail->mdpayapinvoicepayamount = $ap['payamount'];
                $detail->mdpayapinvoicediscount = 0;
                $detail->mdpayapuserid = Auth::user()->id;
                $detail->mdpayapusername = Auth::user()->name;
                $detail->mdpayapeventdate = Carbon::now();
                $detail->mdpayapeventtime = Carbon::now();
                $detail->void = 0;
                $detail->save();

                // reset AP
                $new_ap = new MAPCard;
                $new_ap->setConnection(Auth::user()->db_name);
                $new_ap->mapcardsupplierid = $header->mhpayapsupplierno;
                $new_ap->mapcardsuppliername = $header->mhpayapsuppliername;
                $new_ap->mapcardtdate = Carbon::now();
                $new_ap->mapcardtransno = $old_ap->mapcardtransno;
                $new_ap->mapcardpayno = $header->mhpayapno;
                $new_ap->mapcardremark = "Revisi Hutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
                $new_ap->mapcardduedate = $old_ap->mapcardduedate;
                $new_ap->mapcardtotalinv = $old_ap->mapcardtotalinv;
                $new_ap->mapcardpayamount = 0;
                $new_ap->mapcardoutstanding = $old_ap->mapcardoutstanding + $last_pay;
                $new_ap->mapcardusername = Auth::user()->name;
                $new_ap->mapcarduserid = Auth::user()->id;
                $new_ap->mapcardeventdate = Carbon::now();
                $new_ap->mapcardeventtime = Carbon::now();
                $new_ap->void = 0;
                $new_ap->save();

                $new_ap = new MAPCard;
                $new_ap->setConnection(Auth::user()->db_name);
                $new_ap->mapcardsupplierid = $header->mhpayapsupplierno;
                $new_ap->mapcardsuppliername = $header->mhpayapsuppliername;
                $new_ap->mapcardtdate = Carbon::now();
                $new_ap->mapcardtransno = $old_ap->mapcardtransno;
                $new_ap->mapcardpayno = $header->mhpayapno;
                $new_ap->mapcardremark = "Revisi Hutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
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

                $last_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$detail->mdpayaptransno)->where('mjournaltranstype','Pembelian')->first();

                $last_details_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$detail->mhpayapno)->where('mjournaltranstype','Pembayaran Hutang')->get();

                $debit = $last_journal->mjournaldebit - $detail->mdpayapinvoicepayamount;
                $credit = $detail->mdpayapinvoicepayamount;
                $last_details_journal[0]->mjournaldebit = $debit;
                $last_details_journal[0]->save();
                $last_details_journal[1]->mjournalcredit = $credit;
                $last_details_journal[1]->save();
            }

            //voided details
            $voided_details = MDPayAP::on(Auth::user()->db_name)->where('mhpayapno',$header->mhpayapno)->where('void',1)->get();
            foreach($voided_details as $v){
                $old_ap = MAPCard::on(Auth::user()->db_name)->where('id',$v->mdpayap_apref)->first();

                $detail = MDPayAP::on(Auth::user()->db_name)->where('mhpayapno',$header->mhpayapno)->where('mdpayaptransno',$v->mdpayaptransno)->first();

                $last_pay = $detail->mdpayapinvoicepayamount;

                // reset AP
                $new_ap = new MAPCard;
                $new_ap->setConnection(Auth::user()->db_name);
                $new_ap->mapcardsupplierid = $header->mhpayapsupplierno;
                $new_ap->mapcardsuppliername = $header->mhpayapsuppliername;
                $new_ap->mapcardtdate = Carbon::now();
                $new_ap->mapcardtransno = $old_ap->mapcardtransno;
                $new_ap->mapcardpayno = $header->mhpayapno;
                $new_ap->mapcardremark = "Pembatalan Hutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
                $new_ap->mapcardduedate = $old_ap->mapcardduedate;
                $new_ap->mapcardtotalinv = $old_ap->mapcardtotalinv;
                $new_ap->mapcardpayamount = 0;
                $new_ap->mapcardoutstanding = $old_ap->mapcardoutstanding + $last_pay;
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
            return "err";
        }
    }

    public function delete_transaction(){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{

            $this->void = 1;
            $this->save();

            $details = MDPayAP::on(Auth::user()->db_name)->where('mhpayapno',$this->mhpayapno)->get();

            foreach ($details as $d) {
                $d->void = 1;
                $d->save();

                // $old_ap = MAPCard::on(Auth::user()->db_name)->where('id',$d->id)->first();
                $old_ap = MAPCard::on(Auth::user()->db_name)->where('mapcardpayno',$this->mhpayapno)->where('mapcardtransno',$d->mdpayaptransno)->orderBy('created_at', 'desc')->first();
                $detail = MDPayAP::on(Auth::user()->db_name)->where('mhpayapno',$this->mhpayapno)->where('mdpayaptransno',$d->mdpayaptransno)->first();

                $last_pay = $detail->mdpayapinvoicepayamount;

                // cancel AP
                $new_ap = new MAPCard;
                $new_ap->setConnection(Auth::user()->db_name);
                $new_ap->mapcardsupplierid = $this->mhpayapsupplierno;
                $new_ap->mapcardsuppliername = $this->mhpayapsuppliername;
                $new_ap->mapcardtdate = Carbon::now();
                $new_ap->mapcardtransno = $old_ap->mapcardtransno;
                $new_ap->mapcardpayno = $this->mhpayapno;
                $new_ap->mapcardremark = "Pembatalan Hutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
                $new_ap->mapcardduedate = $old_ap->mapcardduedate;
                $new_ap->mapcardtotalinv = $old_ap->mapcardtotalinv;
                $new_ap->mapcardpayamount = 0;
                $new_ap->mapcardoutstanding = $old_ap->mapcardoutstanding + $last_pay;
                $new_ap->mapcardusername = Auth::user()->name;
                $new_ap->mapcarduserid = Auth::user()->id;
                $new_ap->mapcardeventdate = Carbon::now();
                $new_ap->mapcardeventtime = Carbon::now();
                $new_ap->void = 0;
                $new_ap->save();

                $last_details_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$detail->mhpayapno)->where('mjournaltranstype','Pembayaran Hutang')->get();

                $last_details_journal[0]->void = 1;
                $last_details_journal[0]->save();
                $last_details_journal[1]->void = 1;
                $last_details_journal[1]->save();
            }

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return "err";
        }
    }
}
