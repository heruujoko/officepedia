<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MConfig;
use App\MCUSTOMER;
use Carbon\Carbon;
use Auth;
use DB;
use App\Helper\DBHelper;
use App\MCOA;
use App\MDPayAR;

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

    public function has_detail_in_warehouses($warehouse_ids){
        $details = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$this->mhpayarno)->whereIn('mdpayarwarehouseid',$warehouse_ids)->get()->toArray();
        return (sizeof($details) > 0);
    }

    public static function start_transaction($request){
      DB::connection(Auth::user()->db_name)->beginTransaction();
      try{

          $header = new MHPayAR;
          $header->setConnection(Auth::user()->db_name);
          $header->mhpayarno = "";
          $header->mhpayarcustomerno = MCUSTOMER::on(Auth::user()->db_name)->where('id',$request->invoice_customer)->first()->mcustomerid;
          $header->mhpayarcustomername = MCUSTOMER::on(Auth::user()->db_name)->where('id',$request->invoice_customer)->first()->mcustomername;
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
              $header->mhpayarno = $request->no;
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
              $detail->mdpayarwarehouseid = $old_ar->marcardwarehouseid;
              $detail->save();

              $new_ar = new MARCard;
              $new_ar->setConnection(Auth::user()->db_name);
              $new_ar->marcardcustomerid = $header->mhpayarcustomerno;
              $new_ar->marcardcustomername = $header->mhpayarcustomername;
              $new_ar->marcarddate = Carbon::parse($request->invoice_date);
              $new_ar->marcardtransno = $old_ar->marcardtransno;
              $new_ar->marcardtranstype = "Pembayaran Piutang Dagang";
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
              $new_ar->marcardwarehouseid = $old_ar->marcardwarehouseid;
              $new_ar->void = 0;
              $new_ar->save();

              $detail->mdpayar_arref = $new_ar->id;
              $detail->save();

              // if payment with cash
              if($detail->mdpayarcashcoa != ""){
                  $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarcashcoa)->first();
                  // update journal
                  MJournal::record_journal_cash($header->mhpayarno,'Pembayaran Piutang',$detail->mdpayarcashcoa,$detail->mdpayarcashamount,0,"","",$detail->id,$request->invoice_date);
                  MJournal::record_journal_cash($header->mhpayarno,'Pembayaran Piutang',$coa,0,$detail->mdpayarcashamount,"","",$detail->id,$request->invoice_date);

                  // update coa saldo
                  $coa_cash->update_saldo('+',$detail->mdpayarcashamount);
                  $coa_ar->update_saldo('-',$detail->mdpayarcashamount);
              }

              // if payment with bank
              if($detail->mdpayarbankcoa != ""){
                  $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarbankcoa)->first();
                  // update journal
                  MJournal::record_journal_bank($header->mhpayarno,'Pembayaran Piutang',$detail->mdpayarbankcoa,$detail->mdpayarbankamount,0,"","",$detail->id,$request->invoice_date);
                  MJournal::record_journal_bank($header->mhpayarno,'Pembayaran Piutang',$coa,0,$detail->mdpayarbankamount,"","",$detail->id,$request->invoice_date);

                  // update coa saldo
                  $coa_bank->update_saldo('+',$detail->mdpayarbankamount);
                  $coa_ar->update_saldo('-',$detail->mdpayarbankamount);
              }
          }
          MJournal::add_prefix();
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

            /* revert coa saldo */
            $coa_ar->update_saldo('+',$header->mhpayarpayamount);

            $header->mhpayarcustomerno = MCUSTOMER::on(Auth::user()->db_name)->where('id',$request->invoice_customer)->first()->mcustomerid;
            $header->mhpayarcustomername = MCUSTOMER::on(Auth::user()->db_name)->where('id',$request->invoice_customer)->first()->mcustomername;
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

            $details = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$header->mhpayarno)->get();
            foreach ($details as $d) {
                $d->void = 1;
                $d->save();
            }

            foreach ($request->ars as $ar) {

                if(array_key_exists('mdpayartransno',$ar)){
                    $old_ar = MARCard::on(Auth::user()->db_name)->where('id',$ar['mdpayar_arref'])->first();
                    $detail = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$header->mhpayarno)->where('mdpayartransno',$ar['mdpayartransno'])->first();
                    if($ar['payamount'] != $old_ar->marcardpayamount){
                        var_dump('kurangin');
                        // reset coa saldo
                        $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarcashcoa)->first();
                        if($coa_cash != null){
                            $coa_ar->update_saldo('+',$detail->mdpayarcashamount);
                            $coa_cash->update_saldo('-',$detail->mdpayarcashamount);
                        }
                        $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarbankcoa)->first();
                        if($coa_bank != null){
                            $coa_ar->update_saldo('+',$detail->mdpayarbankamount);
                            $coa_bank->update_saldo('-',$detail->mdpayarbankamount);
                        }
                    }
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

                    $detail->mdpayarcashcoa = $ar['payments']['cash']['coa'];
                    $detail->mdpayarcashamount = $ar['payments']['cash']['amount'];
                    $detail->mdpayarbankcoa = $ar['payments']['bank']['coa'];
                    $detail->mdpayarbankamount = $ar['payments']['bank']['amount'];
                    $detail->mdpayarbankbankname = $ar['payments']['bank']['bank_name'];
                    $detail->mdpayarwarehouseid = $old_ar->marcardwarehouseid;
                    $detail->void = 0;
                    $detail->save();

                    $ars = MARCard::on(Auth::user()->db_name)->where('id',$detail->mdpayar_arref)->first();
                    $ars->marcarddate = Carbon::parse($request->invoice_date);
                    $ars->save();

                    $this_transaction_journal = MJournal::on(Auth::user()->db_name)->where('mdpayar_ref',$detail->id)->get();
                    foreach ($this_transaction_journal as $tjournal) {
                        $tjournal->mjournaldate = Carbon::parse($request->invoice_date);
                        $tjournal->save();
                    }

                    // only update if payamount is changed
                    if($ar['payamount'] != $old_ar->marcardpayamount){

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
                        $new_ar->marcardoutstanding = $old_ar->marcardoutstanding + $old_ar->marcardpayamount;
                        $new_ar->marcardusername = Auth::user()->name;
                        $new_ar->marcarduserid = Auth::user()->id;
                        $new_ar->marcardusereventdate = Carbon::now();
                        $new_ar->marcardusereventtime = Carbon::now();
                        $new_ar->void = 0;
//                        $new_ar->save();

                        $reset_outstanding = $new_ar->marcardoutstanding;

                        $new_ar = new MARCard;
                        $new_ar->setConnection(Auth::user()->db_name);
                        $new_ar->marcardcustomerid = $header->mhpayarcustomerno;
                        $new_ar->marcardcustomername = $header->mhpayarcustomername;
                        $new_ar->marcarddate = Carbon::parse($request->invoice_date);
                        $new_ar->marcardtransno = $old_ar->marcardtransno;
                        $new_ar->marcardpayno = $header->mhpayarno;
                        $new_ar->marcardremark = "Revisi Piutang Dagang oleh ".Auth::user()->name."/".Auth::user()->id;
                        $new_ar->marcardduedate = $old_ar->marcardduedate;
                        $new_ar->marcardtotalinv = $old_ar->marcardtotalinv;
                        $new_ar->marcardpayamount = $ar['payamount'];
                        $new_ar->marcardoutstanding = $reset_outstanding - $ar['payamount'];
                        $new_ar->marcardusername = Auth::user()->name;
                        $new_ar->marcarduserid = Auth::user()->id;
                        $new_ar->marcardusereventdate = Carbon::now();
                        $new_ar->marcardusereventtime = Carbon::now();
                        $new_ar->void = 0;
                        $new_ar->save();

                        $oldmarcard = MARCard::on(Auth::user()->db_name)->where('id',$detail->mdpayar_arref)->first();
                        $oldmarcard->void = 1;
                        $oldmarcard->save();
                        $detail->mdpayar_arref = $new_ar->id;
                        // update journal
                        $this_transaction_journal = MJournal::on(Auth::user()->db_name)->where('mdpayar_ref',$detail->id)->get();
                        var_dump(count($this_transaction_journal));

                        foreach ($this_transaction_journal as $tjournal) {
                            $tjournal->mjournaldate = Carbon::parse($request->invoice_date);
                            $tjournal->save();
                        }

                        // there will be 4 records

                        // the first two is for cash payment
                        if(($this_transaction_journal[0]->paymenttype == "cash") && ($this_transaction_journal[1]->paymenttype == "cash")){
                            $this_transaction_journal[0]->mjournaldebit = $detail->mdpayarcashamount;
                            $this_transaction_journal[1]->mjournalcredit = $detail->mdpayarcashamount;
                            $this_transaction_journal[0]->mjournalcoa = $detail->mdpayarcashcoa;
                            $this_transaction_journal[0]->save();
                            $this_transaction_journal[1]->save();
                            // update coa saldo
                            $coa_cash->update_saldo('+',$detail->mdpayarcashamount);
                            $coa_ar->update_saldo('-',$detail->mdpayarcashamount);
                        }

                        // the next two is for bank payment
                        if(($this_transaction_journal[0]->paymenttype == "bank") && ($this_transaction_journal[1]->paymenttype == "bank")){
                            $this_transaction_journal[0]->mjournaldebit = $detail->mdpayarbankamount;
                            $this_transaction_journal[1]->mjournalcredit = $detail->mdpayarbankamount;
                            $this_transaction_journal[0]->mjournalcoa = $detail->mdpayarbankcoa;
                            $this_transaction_journal[0]->save();
                            $this_transaction_journal[1]->save();
                            // update coa saldo
                            $coa_bank->update_saldo('+',$detail->mdpayarbankamount);
                            $coa_ar->update_saldo('-',$detail->mdpayarbankamount);
                        }

                    }

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
                    $new_ar->marcardtranstype = "Pembayaran Piutang Dagang";
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

                    // if payment with cash

                    if($detail->mdpayarcashcoa != ""){
                        $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarcashcoa)->first();

                        // update journal
                        MJournal::record_journal_cash($header->mhpayarno,'Pembayaran Piutang',$detail->mdpayarcashcoa,$detail->mdpayarcashamount,0,"","",$detail->id,$request->invoice_date);
                        MJournal::record_journal_cash($header->mhpayarno,'Pembayaran Piutang',$coa,0,$detail->mdpayarcashamount,"","",$detail->id,$request->invoice_date);

                        // update coa saldo
                        $coa_cash->update_saldo('+',$detail->mdpayarcashamount);
                        $coa_ar->update_saldo('-',$detail->mdpayarcashamount);
                    }

                    // if payment with bank

                    if($detail->mdpayarbankcoa != ""){
                        $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarbankcoa)->first();

                        // update journal
                        MJournal::record_journal_bank($header->mhpayarno,'Pembayaran Piutang',$coa,0,$detail->mdpayarbankamount,"","",$detail->id,$request->invoice_date);
                        MJournal::record_journal_bank($header->mhpayarno,'Pembayaran Piutang',$detail->mdpayarbankcoa,$detail->mdpayarbankamount,0,"","",$detail->id,$request->invoice_date);

                        // update coa saldo
                        $coa_bank->update_saldo('+',$detail->mdpayarbankamount);
                        $coa_ar->update_saldo('-',$detail->mdpayarbankamount);
                    }
                }
            }

            //voided details
            $voided_details = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$header->mhpayarno)->where('void',1)->get();
            foreach($voided_details as $v){
                $old_ap = MARCard::on(Auth::user()->db_name)->where('id',$v->mdpayar_arref)->first();

                $detail = MDPayAR::on(Auth::user()->db_name)->where('mhpayarno',$header->mhpayarno)->where('mdpayartransno',$v->mdpayartransno)->first();

                $last_pay = $detail->mdpayarinvoicepayamount;

                // reset coa saldo
                $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarcashcoa)->first();
                if($coa_cash != null){
                    $coa_ar->update_saldo('+',$detail->mdpayarcashamount);
                    $coa_cash->update_saldo('-',$detail->mdpayarcashamount);
                }

                $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarbankcoa)->first();
                if($coa_bank != null){
                    $coa_ar->update_saldo('+',$detail->mdpayarbankamount);
                    $coa_bank->update_saldo('-',$detail->mdpayarbankamount);
                }

                // update journal
                $this_transaction_journal = MJournal::on(Auth::user()->db_name)->where('mdpayar_ref',$detail->id)->get();
                // there will be 4 records
                foreach ($this_transaction_journal as $journal) {
                    $journal->void = 1;
                    $journal->save();
                }

                // reset AR
                $new_ar = new MARCard;
                $new_ar->setConnection(Auth::user()->db_name);
                $new_ar->marcardcustomerid = $header->mhpayarcustomerno;
                $new_ar->marcardcustomername = $header->mhpayarcustomername;
                $new_ar->marcarddate = Carbon::now();
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

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            dd($e);
            return 'err';
        }
    }

    public function delete_transaction(){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{

            $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            $coa = $conf->msyspayaraccount;
            $coa_ar = MCOA::on(Auth::user()->db_name)->where('mcoacode',$coa)->first();

            /* revert coa saldo */
            $coa_ar->update_saldo('+',$this->mhpayarpayamount);


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

                // reset coa saldo
                $coa_cash = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarcashcoa)->first();
                if($coa_cash != null){
                    $coa_ar->update_saldo('+',$detail->mdpayarcashamount);
                    $coa_cash->update_saldo('-',$detail->mdpayarcashamount);
                }

                $coa_bank = MCOA::on(Auth::user()->db_name)->where('mcoacode',$detail->mdpayarbankcoa)->first();
                if($coa_bank != null){
                    $coa_ar->update_saldo('+',$detail->mdpayarbankamount);
                    $coa_bank->update_saldo('-',$detail->mdpayarbankamount);
                }

                // update journal
                $this_transaction_journal = MJournal::on(Auth::user()->db_name)->where('mdpayar_ref',$detail->id)->get();
                // there will be 4 records
                foreach ($this_transaction_journal as $journal) {
                    $journal->void = 1;
                    $journal->save();
                }

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

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return "err";
        }
    }
}
