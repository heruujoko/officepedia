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
            $coa_ap = MCOA::on(Auth::user()->db_name)->where('mcoacode',$coa)->first();

            foreach($request->aps as $ap){

                $old_ap = MAPCard::on(Auth::user()->db_name)->where('mapcardtransno',$ap['mapcardtransno'])->get()->last();

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
                $detail->mdpayapcashcoa = $ap['payments']['cash']['coa'];
                $detail->mdpayapcashamount = $ap['payments']['cash']['amount'];
                $detail->mdpayapbankcoa = $ap['payments']['bank']['coa'];
                $detail->mdpayapbankamount = $ap['payments']['bank']['amount'];
                $detail->mdpayapbankbankname = $ap['payments']['bank']['bank_name'];
                $detail->save();

                $new_ap = new MAPCard;
                $new_ap->setConnection(Auth::user()->db_name);
                $new_ap->mapcardsupplierid = $header->mhpayapsupplierno;
                $new_ap->mapcardsuppliername = $header->mhpayapsuppliername;
                $new_ap->mapcardtdate = Carbon::now();
                $new_ap->mapcardtransno = $old_ap->mapcardtransno;
                $new_ap->mapcardpayno = $header->mhpayapno;
                $new_ap->mapcardtranstype = "Pembayaran Hutang Dagang";
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

                // if payment with cash

                if($detail->mdpayapcashcoa != ""){
                    $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayapcashcoa)->first();

                    // update journal
                    MJournal::record_journal($header->mhpayapno,'Pembayaran Hutang',$coa,$detail->mdpayapcashamount,0,"",$detail->id,"");
                    MJournal::record_journal($header->mhpayapno,'Pembayaran Hutang',$detail->mdpayapcashcoa,0,$detail->mdpayapcashamount,"",$detail->id,"");

                    // update coa saldo
                    $coa_cash->update_saldo('-',$detail->mdpayapcashamount);
                    $coa_ap->update_saldo('-',$detail->mdpayapcashamount);
                }

                // if payment with bank

                if($detail->mdpayapbankcoa != ""){
                    $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayapbankcoa)->first();

                    // update journal
                    MJournal::record_journal($header->mhpayapno,'Pembayaran Hutang',$coa,$detail->mdpayapbankamount,0,"",$detail->id,"");
                    MJournal::record_journal($header->mhpayapno,'Pembayaran Hutang',$detail->mdpayapbankcoa,0,$detail->mdpayapbankamount,"",$detail->id,"");

                    // update coa saldo
                    $coa_bank->update_saldo('-',$detail->mdpayapbankamount);
                    $coa_ap->update_saldo('-',$detail->mdpayapbankamount);
                }

            }
            MJournal::add_prefix();
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

            $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            $coa = $conf->msyspayapaccount;
            $coa_ap = MCOA::on(Auth::user()->db_name)->where('mcoacode',$coa)->first();
            $header = MHPayAP::on(Auth::user()->db_name)->where('id',$this->id)->first();

            $header->mhpayapsupplierno = MSupplier::on(Auth::user()->db_name)->where('id',$request->invoice_supplier)->first()->msupplierid;
            $header->mhpayapsuppliername = MSupplier::on(Auth::user()->db_name)->where('id',$request->invoice_supplier)->first()->msuppliername;
            $header->mhpayapdate = Carbon::parse($request->invoice_date);
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

            foreach ($request->aps as $ap) {
                if(array_key_exists('mdpayaptransno',$ap)){

                    $detail = MDPayAP::on(Auth::user()->db_name)->where('mhpayapno',$header->mhpayapno)->where('mdpayaptransno',$ap['mdpayaptransno'])->first();
                    $old_ap = MAPCard::on(Auth::user()->db_name)->where('id',$ap['mdpayap_apref'])->first();
                    $last_pay = $detail->mdpayapinvoicepayamount;
                    if($ap['payamount'] != $old_ap->mapcardpayamount){
                        // reset coa saldo
                        $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayapcashcoa)->first();
                        if($coa_cash != null){
                            $coa_ap->update_saldo('+',$detail->mdpayapcashamount);
                            $coa_cash->update_saldo('+',$detail->mdpayapcashamount);
                        }
                        $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayapbankcoa)->first();
                        if($coa_bank != null){
                            $coa_ap->update_saldo('+',$detail->mdpayapbankamount);
                            $coa_bank->update_saldo('+',$detail->mdpayapbankamount);
                        }
                    }

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

                    $detail->mdpayapcashcoa = $ap['payments']['cash']['coa'];
                    $detail->mdpayapcashamount = $ap['payments']['cash']['amount'];
                    $detail->mdpayapbankcoa = $ap['payments']['bank']['coa'];
                    $detail->mdpayapbankamount = $ap['payments']['bank']['amount'];
                    $detail->mdpayapbankbankname = $ap['payments']['bank']['bank_name'];

                    $detail->void = 0;
                    $detail->save();

                    // only update APCARD if the amount is different

                    if($ap['payamount'] != $old_ap->mapcardpayamount){
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
//                        $new_ap->save();

                        $new_ap = new MAPCard;
                        $new_ap->setConnection(Auth::user()->db_name);
                        $new_ap->mapcardsupplierid = $header->mhpayapsupplierno;
                        $new_ap->mapcardsuppliername = $header->mhpayapsuppliername;
                        $new_ap->mapcardtdate = Carbon::now();
                        $new_ap->mapcardtransno = $old_ap->mapcardtransno;
                        $new_ap->mapcardpayno = $header->mhpayapno;
                        $new_ap->mapcardtranstype ="Pembayaran Hutang";
                        $new_ap->mapcardremark = "Revisi Hutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
                        $new_ap->mapcardduedate = $old_ap->mapcardduedate;
                        $new_ap->mapcardtotalinv = $old_ap->mapcardtotalinv;
                        $new_ap->mapcardpayamount = $ap['payamount'];
                        $new_ap->mapcardoutstanding = ($old_ap->mapcardoutstanding + $last_pay) - $ap['payamount'];
                        $new_ap->mapcardusername = Auth::user()->name;
                        $new_ap->mapcarduserid = Auth::user()->id;
                        $new_ap->mapcardeventdate = Carbon::now();
                        $new_ap->mapcardeventtime = Carbon::now();
                        $new_ap->void = 0;
                        $new_ap->save();
                        $detail->mdpayap_apref = $new_ap->id;

                        $oldmapcard = MAPCard::on(Auth::user()->db_name)->where('id',$detail->mdpayap_apref)->first();
                        $oldmapcard->void = 1;
                        $oldmapcard->save();

                        // update journal
                        $this_transaction_journal = MJournal::on(Auth::user()->db_name)->where('mdpayap_ref',$detail->id)->get();
                        // there will be 4 records

                        // the first two is for cash payment
                        if(isset($this_transaction_journal[0]) && isset($this_transaction_journal[1])){
                            $this_transaction_journal[0]->mjournaldebit = $detail->mdpayapcashamount;
                            $this_transaction_journal[1]->mjournalcredit = $detail->mdpayapcashamount;
                            $this_transaction_journal[1]->mjournalcoa = $detail->mdpayapcashcoa;
                            $this_transaction_journal[0]->save();
                            $this_transaction_journal[1]->save();
                        }

                        // the next two is for bank payment
                        if(isset($this_transaction_journal[2]) && isset($this_transaction_journal[3])){
                            $this_transaction_journal[2]->mjournaldebit = $detail->mdpayapbankamount;
                            $this_transaction_journal[3]->mjournalcredit = $detail->mdpayapbankamount;
                            $this_transaction_journal[3]->mjournalcoa = $detail->mdpayapbankcoa;
                            $this_transaction_journal[2]->save();
                            $this_transaction_journal[3]->save();
                        }

                        // update coa saldo
                        $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayapcashcoa)->first();
                        if($coa_cash != null){
                            $coa_ap->update_saldo('-',$detail->mdpayapcashamount);
                            $coa_cash->update_saldo('-',$detail->mdpayapcashamount);
                        }
                        $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayapbankcoa)->first();
                        if($coa_bank != null){
                            $coa_ap->update_saldo('-',$detail->mdpayapbankamount);
                            $coa_bank->update_saldo('-',$detail->mdpayapbankamount);
                        }
                    }

                } else {
                    // is a new detail
                    $detail = new MDPayAP;
                    $detail->setConnection(Auth::user()->db_name);
                    $detail->mhpayapno = $header->mhpayapno;
                    $detail->mdpayaptransno = $ap['mapcardtransno'];
                    $detail->mdpayapinvoicetotal = $ap['mapcardtotalinv'];
                    $detail->mdpayapinvoicedate = $header->mhpayapdate;
                    $detail->mdpayapinvoiceoutstanding = $ap['mapcardoutstanding'];
                    $detail->mdpayapinvoicepayamount = $ap['payamount'];
                    $detail->mdpayapinvoicediscount = 0;
                    $detail->mdpayapuserid = Auth::user()->id;
                    $detail->mdpayapusername = Auth::user()->name;
                    $detail->mdpayapeventdate = Carbon::now();
                    $detail->mdpayapeventtime = Carbon::now();
                    $detail->mdpayapcashcoa = $ap['payments']['cash']['coa'];
                    $detail->mdpayapcashamount = $ap['payments']['cash']['amount'];
                    $detail->mdpayapbankcoa = $ap['payments']['bank']['coa'];
                    $detail->mdpayapbankamount = $ap['payments']['bank']['amount'];
                    $detail->mdpayapbankbankname = $ap['payments']['bank']['bank_name'];
                    $detail->save();

                    $new_ap = new MAPCard;
                    $new_ap->setConnection(Auth::user()->db_name);
                    $new_ap->mapcardsupplierid = $header->mhpayapsupplierno;
                    $new_ap->mapcardsuppliername = $header->mhpayapsuppliername;
                    $new_ap->mapcardtdate = Carbon::now();
                    $new_ap->mapcardtransno = $ap['mapcardtransno'];
                    $new_ap->mapcardtranstype = 'Pembayaran Hutang';
                    $new_ap->mapcardpayno = $header->mhpayapno;
                    $new_ap->mapcardremark = "Pembayaran Hutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
                    $new_ap->mapcardduedate = $ap['mapcardduedate'];
                    $new_ap->mapcardtotalinv = $ap['mapcardtotalinv'];
                    $new_ap->mapcardpayamount = $ap['payamount'];
                    $new_ap->mapcardoutstanding = $ap['mapcardtotalinv'] - $ap['payamount'];
                    $new_ap->mapcardusername = Auth::user()->name;
                    $new_ap->mapcarduserid = Auth::user()->id;
                    $new_ap->mapcardeventdate = Carbon::now();
                    $new_ap->mapcardeventtime = Carbon::now();
                    $new_ap->void = 0;
                    $new_ap->save();

                    $detail->mdpayap_apref = $new_ap->id;
                    $detail->save();

                    // if payment with cash

                    if($detail->mdpayapcashcoa != ""){
                        $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayapcashcoa)->first();

                        // update journal
                        MJournal::record_journal($header->mhpayapno,'Pembayaran Hutang',$detail->mdpayapcashcoa,0,$detail->mdpayapcashamount,"",$detail->id,"");
                        MJournal::record_journal($header->mhpayapno,'Pembayaran Hutang',$coa,$detail->mdpayapcashamount,0,"",$detail->id,"");

                        // update coa saldo
                        $coa_cash->update_saldo('-',$detail->mdpayapcashamount);
                        $coa_ap->update_saldo('-',$detail->mdpayapcashamount);
                    }

                    // if payment with bank

                    if($detail->mdpayapbankcoa != ""){
                        $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayapbankcoa)->first();

                        // update journal
                        MJournal::record_journal($header->mhpayapno,'Pembayaran Hutang',$coa,$detail->mdpayapbankamount,0,"",$detail->id,"");
                        MJournal::record_journal($header->mhpayapno,'Pembayaran Hutang',$detail->mdpayapbankcoa,0,$detail->mdpayapbankamount,"",$detail->id,"");

                        // update coa saldo
                        $coa_bank->update_saldo('-',$detail->mdpayapbankamount);
                        $coa_ap->update_saldo('-',$detail->mdpayapbankamount);
                    }
                }
            }

            //voided details
            $voided_details = MDPayAP::on(Auth::user()->db_name)->where('mhpayapno',$header->mhpayapno)->where('void',1)->get();
            foreach($voided_details as $v){
                $old_ap = MAPCard::on(Auth::user()->db_name)->where('id',$v->mdpayap_apref)->first();

                $detail = MDPayAP::on(Auth::user()->db_name)->where('mhpayapno',$header->mhpayapno)->where('mdpayaptransno',$v->mdpayaptransno)->first();

                $last_pay = $detail->mdpayapinvoicepayamount;

                // reset coa saldo
                $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayapcashcoa)->first();
                if($coa_cash != null){
                    $coa_ap->update_saldo('+',$detail->mdpayapcashamount);
                    $coa_cash->update_saldo('+',$detail->mdpayapcashamount);
                }

                $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayapbankcoa)->first();
                if($coa_bank != null){
                    $coa_ap->update_saldo('+',$detail->mdpayapbankamount);
                    $coa_bank->update_saldo('+',$detail->mdpayapbankamount);
                }

                // update journal
                $this_transaction_journal = MJournal::on(Auth::user()->db_name)->where('mdpayap_ref',$detail->id)->get();
                // there will be 4 records
                foreach ($this_transaction_journal as $journal) {
                    $journal->void = 1;
                    $journal->save();
                }

                // reset AP
                $new_ap = new MAPCard;
                $new_ap->setConnection(Auth::user()->db_name);
                $new_ap->mapcardsupplierid = $header->mhpayapsupplierno;
                $new_ap->mapcardsuppliername = $header->mhpayapsuppliername;
                $new_ap->mapcardtdate = Carbon::now();
                $new_ap->mapcardtransno = $old_ap->mapcardtransno;
                $new_ap->mapcardtransno = "Pembatalan Hutang";
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
            dd($e);
            return "err";
        }
    }

    public function delete_transaction(){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{

            $this->void = 1;
            $this->save();

            $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            $coa = $conf->msyspayapaccount;
            $coa_ap = MCOA::on(Auth::user()->db_name)->where('mcoacode',$coa)->first();


            $details = MDPayAP::on(Auth::user()->db_name)->where('mhpayapno',$this->mhpayapno)->get();

            foreach ($details as $d) {

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

                // reset coa saldo
                $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$d->mdpayapcashcoa)->first();
                if($coa_cash != null){
                    $coa_ap->update_saldo('+',$d->mdpayapcashamount);
                    $coa_cash->update_saldo('+',$d->mdpayapcashamount);
                }

                $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$d->mdpayapbankcoa)->first();
                if($coa_bank != null){
                    $coa_ap->update_saldo('+',$d->mdpayapbankamount);
                    $coa_bank->update_saldo('+',$d->mdpayapbankamount);
                }


                // update journal
                $this_transaction_journal = MJournal::on(Auth::user()->db_name)->where('mdpayap_ref',$d->id)->get();
                // there will be 4 records
                foreach ($this_transaction_journal as $journal) {
                    $journal->void = 1;
                    $journal->save();
                }

                $d->void = 1;
                $d->save();
            }

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            dd($e);
            return "err";
        }
    }
}
