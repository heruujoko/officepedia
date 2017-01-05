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
use App\MCOA;

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
          $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
          $coa = $conf->msyspayaraccount;
          $coa_ar = MCOA::on(Auth::user()->db_name)->where('mcoacode',$coa)->first();

          foreach($request->ars as $ar){

              $old_ar = MARCard::on(Auth::user()->db_name)->where('marcardtransno',$ar['marcardtransno'])->get()->last();

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
              $detail->mdpayarcashcoa = $ar['payments']['cash']['coa'];
              $detail->mdpayarcashamount = $ar['payments']['cash']['amount'];
              $detail->mdpayarbankcoa = $ar['payments']['bank']['coa'];
              $detail->mdpayarbankamount = $ar['payments']['bank']['amount'];
              $detail->mdpayarbankbankname = $ar['payments']['bank']['bank_name'];
              $detail->save();

              $new_ar = new MARCard;
              $new_ar->setConnection(Auth::user()->db_name);
              $new_ar->marcardcustomerid = $header->mhpayarcustomerno;
              $new_ar->marcardcustomername = $header->mhpayarcustomername;
              $new_ar->marcarddate = Carbon::now();
              $new_ar->marcardtransno = $old_ar->marcardtransno;
              $new_ar->marcardpayno = $header->mhpayarno;
              $new_ar->marcardremark = "Pembayaran Piutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
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

              // if payment with cash
              if($detail->mdpayarcashcoa != ""){
                  $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarcashcoa)->first();
                  // update journal
                  MJournal::record_journal($header->mhpayarno,'Pembayaran Piutang',$coa,$detail->mdpayarcashamount,0,"",$detail->id,"");
                  MJournal::record_journal($header->mhpayarno,'Pembayaran Piutang',$detail->mdpayarcashcoa,0,$detail->mdpayarcashamount,"",$detail->id,"");

                  // update coa saldo
                  $coa_cash->update_saldo('-',$detail->mdpayarcashamount);
                  $coa_ar->update_saldo('-',$detail->mdpayarcashamount);
              }

              // if payment with bank
              if($detail->mdpayarbankcoa != ""){
                  $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarbankcoa)->first();
                  // update journal
                  MJournal::record_journal($header->mhpayarno,'Pembayaran Piutang',$coa,$detail->mdpayarbankamount,0,"",$detail->id,"");
                  MJournal::record_journal($header->mhpayarno,'Pembayaran Piutang',$detail->mdpayarbankcoa,0,$detail->mdpayarbankamount,"",$detail->id,"");

                  // update coa saldo
                  $coa_bank->update_saldo('-',$detail->mdpayarbankamount);
                  $coa_ar->update_saldo('-',$detail->mdpayarbankamount);
              }
          }

          DB::connection(Auth::user()->db_name)->commit();
          return "ok";
      } catch(\Exception $e){
          DB::connection(Auth::user()->db_name)->rollBack();
          return "err";
      }

    }

    public function update_transaction($request){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{

            $header = MHPayAR::on(Auth::user()->db_name)->where('id',$this->id)->first();

            $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            $coa = $conf->msyspayaraccount;
            $coa_ar = MCOA::on(Auth::user()->db_name)->where('mcoacode',$coa)->first();
            $coa_bank = MCOA::on(Auth::user()->db_name)->where('id',$header->mhpayarbank)->first();

            /* revert coa saldo */
            $coa_ar->update_saldo('+',$header->mhpayarpayamount);
            $coa_bank->update_saldo('-',$header->mhpayarpayamount);

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

            $details = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$header->mhpayarno)->get();
            foreach ($details as $d) {
                $d->void = 1;
                $d->save();
            }

            foreach ($request->ars as $ar) {

                if(array_key_exists('mdpayartransno',$ar)){
                    $old_ar = MARCard::on(Auth::user()->db_name)->where('id',$ar['mdpayar_arref'])->first();

                    $detail = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$header->mhpayarno)->where('mdpayartransno',$ar['mdpayartransno'])->first();
                    $last_pay = $detail->mdpayarinvoicepayamount;
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
                    $detail->void = 0;
                    $detail->save();

                    // reset AR
                    $new_ar = new MARCard;
                    $new_ar->setConnection(Auth::user()->db_name);
                    $new_ar->marcardcustomerid = $header->mhpayarcustomerno;
                    $new_ar->marcardcustomername = $header->mhpayarcustomername;
                    $new_ar->marcarddate = Carbon::now();
                    $new_ar->marcardtransno = $old_ar->marcardtransno;
                    $new_ar->marcardpayno = $header->mhpayarno;
                    $new_ar->marcardremark = "Revisi Piutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
                    $new_ar->marcardduedate = $old_ar->marcardduedate;
                    $new_ar->marcardtotalinv = $old_ar->marcardtotalinv;
                    $new_ar->marcardpayamount = 0;
                    $new_ar->marcardoutstanding = $old_ar->marcardoutstanding + $last_pay;
                    $new_ar->marcardusername = Auth::user()->name;
                    $new_ar->marcarduserid = Auth::user()->id;
                    $new_ar->marcardusereventdate = Carbon::now();
                    $new_ar->marcardusereventtime = Carbon::now();
                    $new_ar->void = 0;
                    $new_ar->save();

                    $new_ar = new MARCard;
                    $new_ar->setConnection(Auth::user()->db_name);
                    $new_ar->marcardcustomerid = $header->mhpayarcustomerno;
                    $new_ar->marcardcustomername = $header->mhpayarcustomername;
                    $new_ar->marcarddate = Carbon::now();
                    $new_ar->marcardtransno = $old_ar->marcardtransno;
                    $new_ar->marcardpayno = $header->mhpayarno;
                    $new_ar->marcardremark = "Revisi Piutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
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
                } else {
                    /* is a new item */
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
            }

            //voided details
            $voided_details = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$header->mhpayarno)->where('void',1)->get();
            foreach($voided_details as $v){
                $old_ap = MARCard::on(Auth::user()->db_name)->where('id',$v->mdpayar_arref)->first();

                $detail = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$header->mhpayarno)->where('mdpayartransno',$v->mdpayartransno)->first();

                $last_pay = $detail->mdpayarinvoicepayamount;

                // reset AR
                $new_ar = new MAPCard;
                $new_ar->setConnection(Auth::user()->db_name);
                $new_ar->marcardcustomerid = $header->mhpayarcustomerno;
                $new_ar->marcardcustomername = $header->mhpayarcustomername;
                $new_ar->marcardtdate = Carbon::now();
                $new_ar->marcardtransno = $old_ar->marcardtransno;
                $new_ar->marcardpayno = $header->mhpayarno;
                $new_ar->marcardremark = "Pembatalan Hutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
                $new_ar->marcardduedate = $old_ar->marcardduedate;
                $new_ar->marcardtotalinv = $old_ar->marcardtotalinv;
                $new_ar->marcardpayamount = 0;
                $new_ar->marcardoutstanding = $old_ar->marcardoutstanding + $last_pay;
                $new_ar->marcardusername = Auth::user()->name;
                $new_ar->marcarduserid = Auth::user()->id;
                $new_ar->marcardusereventdate = Carbon::now();
                $new_ar->marcardusereventtime = Carbon::now();
                $new_ar->void = 0;
                $new_ar->save();

            }

            $last_details_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhpayarno)->where('mjournaltranstype','Pembayaran Piutang')->get();

            $last_details_journal[0]->mjournalcredit = $header->mhpayarpayamount;
            $last_details_journal[0]->save();
            $last_details_journal[1]->mjournaldebit = $header->mhpayarpayamount;
            $last_details_journal[1]->save();

            $coa_ar->update_saldo('-',$header->mhpayarpayamount);
            $coa_bank->update_saldo('+',$header->mhpayarpayamount);

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return 'err';
        }
    }

    public function delete_transaction(){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{

            $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            $coa = $conf->msyspayaraccount;
            $coa_ar = MCOA::on(Auth::user()->db_name)->where('mcoacode',$coa)->first();
            $coa_bank = MCOA::on(Auth::user()->db_name)->where('id',$this->mhpayarbank)->first();

            /* revert coa saldo */
            $coa_ar->update_saldo('+',$this->mhpayarpayamount);
            $coa_bank->update_saldo('-',$this->mhpayarpayamount);

            $this->void = 1;
            $this->save();

            $details = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$this->mhpayarno)->get();

            foreach ($details as $d) {
                $d->void = 1;
                $d->save();

                // $old_ar = MARCard::on(Auth::user()->db_name)->where('id',$d->id)->first();
                $old_ar = MARCard::on(Auth::user()->db_name)->where('marcardpayno',$this->mhpayarno)->where('marcardtransno',$d->mdpayartransno)->orderBy('created_at', 'desc')->first();

                $detail = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$this->mhpayarno)->where('mdpayartransno',$d->mdpayartransno)->first();

                $last_pay = $detail->mdpayarinvoicepayamount;

                // cancel AP
                $new_ar = new MARCard;
                $new_ar->setConnection(Auth::user()->db_name);
                $new_ar->marcardcustomerid = $this->mhpayarcustomerno;
                $new_ar->marcardcustomername = $this->mhpayarcustomername;
                $new_ar->marcarddate = Carbon::now();
                $new_ar->marcardtransno = $old_ar->marcardtransno;
                $new_ar->marcardpayno = $this->mhpayarno;
                $new_ar->marcardremark = "Pembatalan Piutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
                $new_ar->marcardduedate = $old_ar->marcardduedate;
                $new_ar->marcardtotalinv = $old_ar->marcardtotalinv;
                $new_ar->marcardpayamount = 0;
                $new_ar->marcardoutstanding = $old_ar->marcardoutstanding + $last_pay;
                $new_ar->marcardusername = Auth::user()->name;
                $new_ar->marcarduserid = Auth::user()->id;
                $new_ar->marcardusereventdate = Carbon::now();
                $new_ar->marcardusereventtime = Carbon::now();
                $new_ar->void = 0;
                $new_ar->save();
            }

            $last_details_journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$this->mhpayarno)->where('mjournaltranstype','Pembayaran Piutang')->get();

            $last_details_journal[0]->void = 1;
            $last_details_journal[0]->save();
            $last_details_journal[1]->void = 1;
            $last_details_journal[1]->save();

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return "err";
        }
    }
}
