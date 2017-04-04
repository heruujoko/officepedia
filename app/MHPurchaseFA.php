<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MConfig;
use Carbon\Carbon;
use Auth;
use DB;
use App\MDPurchaseFA;
use App\Helper\DBHelper;
use App\MJournal;
use App\MCOA;

class MHPurchaseFA extends Model
{
    protected $table = 'mhpurchasefixedasset';

    protected static function boot(){
  		parent::boot();
      static::created(function($mhpurchasefa){
        $mhpurchasefa->update_prefix_status();
      });
  	}

    public function update_prefix_status(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixedassetcount = $conf->msysprefixedassetcount+1;
      $conf->msysprefixedassetlastcount = $conf->get_last_count_format($conf->msysprefixedassetcount);
      $conf->save();
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      try{
        DBHelper::configureConnection(Auth::user()->db_alias);
        DB::connection(Auth::user()->db_name)->select(DB::raw('call autogen("mhpurchasefixedasset","'.$conf->msysprefixedasset.'",'.$conf->msysprefixedassetcount.',"mhpurchasefixedassetno",'.$this->id.')'));
      } catch(Exception $e){
        var_dump($e);
        return $e;
      }
    }

    public static function start_transaction($request){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{

          $header = new MHPurchaseFA;
          $header->setConnection(Auth::user()->db_name);
          $header->mhpurchasefixedassetno = $request->asset_no;
          $header->mhpurchasefixedassetname = $request->asset_name;
          $header->mhpurchasefixedassetdate = Carbon::parse($request->asset_date);
          $header->mhpurchasefixedassetreal = $request->asset_real;
          $header->mhpurchasefixedassetcategory = $request->asset_categories;
          $header->mhpurchasefixedassetprice = $request->asset_price;
          $header->save();

          if($request->asset_auto){
            $header->autogenproc();
          }

          $h = MHPurchaseFA::on(Auth::user()->db_name)->where('id',$header->id)->first();

          foreach($request->asset_journals as $jr){

            $detail = new MDPurchaseFA;
            $detail->setConnection(Auth::user()->db_name);
            $detail->mhpurchasefixedassetno = $h->mhpurchasefixedassetno;
            $detail->mdpurchasefixedassetdate = $h->mhpurchasefixedassetdate;
            $detail->mdpurchasefixedassetcoacode = $jr['mdpurchasefixedassetcoacode'];
            $detail->mdpurchasefixedassetcoaname = $jr['mdpurchasefixedassetcoaname'];
            $detail->mdpurchasefixedassetdebit = preg_replace("/[^0-9]/", '', $jr['mdpurchasefixedassetdebit']);
            $detail->mdpurchasefixedassetcredit = preg_replace("/[^0-9]/", '', $jr['mdpurchasefixedassetcredit']);
            $detail->save();

            // add journal

            $journal = new MJournal;
            $journal->setConnection(Auth::user()->db_name);
            $journal->mjournaldate = $h->mhpurchasefixedassetdate;
            $journal->mjournaltransno = $h->mhpurchasefixedassetno;
            $journal->mjournaltranstype = 'purchase asset';
            $journal->mjournalcoa = $detail->mdpurchasefixedassetcoacode;
            $journal->mjournaldebit = $detail->mdpurchasefixedassetdebit;
            $journal->mjournalcredit = $detail->mdpurchasefixedassetcredit;
            $journal->mjournalremark = "";
            $journal->mdpayap_ref = "";
            $journal->mdpayar_ref = "";
            $journal->paymenttype = "system";
            $journal->save();

            // affect account saldo
            $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$journal->mjournalcoa)->first();
            $coa->saldo += $journal->mjournaldebit;
            $coa->saldo -= $journal->mjournalcredit;
            $coa->save();

          }

          MJournal::add_prefix();

          // set journalid in purchase data
          $journal_id = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$h->mhpurchasefixedassetno)->first()->mjournalid;
          $details = MDPurchaseFA::on(Auth::user()->db_name)->where('mhpurchasefixedassetno',$h->mhpurchasefixedassetno)->get();
          foreach($details as $d){
            $d->mdpurchasefixedassetjournalcode = $journal_id;
            $d->save();
          }

          DB::connection(Auth::user()->db_name)->commit();
          return "ok";
        } catch(\Exception $e){
          DB::connection(Auth::user()->db_name)->rollBack();
          return "err";
        }
    }

    public static function update_transaction($id,$request){
      $header = MHPurchaseFA::on(Auth::user()->db_name)->where('id',$id)->first();
      DB::connection(Auth::user()->db_name)->beginTransaction();
      try {

        $header->mhpurchasefixedassetno = $request->asset_no;
        $header->mhpurchasefixedassetname = $request->asset_name;
        $header->mhpurchasefixedassetdate = Carbon::parse($request->asset_date);
        $header->mhpurchasefixedassetreal = $request->asset_real;
        $header->mhpurchasefixedassetcategory = $request->asset_categories;
        $header->mhpurchasefixedassetprice = $request->asset_price;
        $header->save();

        $journal_id = "";

        $details = MDPurchaseFA::on(Auth::user()->db_name)->where('mhpurchasefixedassetno',$header->mhpurchasefixedassetno)->where('void',0)->get();
        foreach($details as $d){
          $d->void = 1;
          $journal_id = $d->mdpurchasefixedassetjournalcode;
          $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$d->mdpurchasefixedassetcoacode)->first();
          $coa->saldo += $d->mdpurchasefixedassetcredit;
          $coa->saldo -= $d->mdpurchasefixedassetdebit;
          $coa->save();
          $d->save();
        }

        MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhpurchasefixedassetno)->delete();

        foreach ($request->asset_journals as $detail) {
            // is old data
            var_dump($header->mhpurchasefixedassetno);
            var_dump($detail['mdpurchasefixedassetcoacode']);
            $d = MDPurchaseFA::on(Auth::user()->db_name)->where('mhpurchasefixedassetno',$header->mhpurchasefixedassetno)->where('mdpurchasefixedassetcoacode',$detail['mdpurchasefixedassetcoacode'])->first();

            if($d != null){
              $d->void = 0;
              $d->save();

              $d->mhpurchasefixedassetno = $header->mhpurchasefixedassetno;
              $d->mdpurchasefixedassetdate = $header->mhpurchasefixedassetdate;
              $d->mdpurchasefixedassetcoacode = $detail['mdpurchasefixedassetcoacode'];
              $d->mdpurchasefixedassetcoaname = $detail['mdpurchasefixedassetcoaname'];
              $d->mdpurchasefixedassetdebit = preg_replace("/[^0-9]/", '', $detail['mdpurchasefixedassetdebit']);
              $d->mdpurchasefixedassetcredit = preg_replace("/[^0-9]/", '', $detail['mdpurchasefixedassetcredit']);
              $d->save();

              // add journal
              $journal = new MJournal;
              $journal->setConnection(Auth::user()->db_name);
              $journal->mjournaldate = $header->mhpurchasefixedassetdate;
              $journal->mjournaltransno = $header->mhpurchasefixedassetno;
              $journal->mjournaltranstype = 'purchase asset';
              $journal->mjournalcoa = $d->mdpurchasefixedassetcoacode;
              $journal->mjournaldebit = $d->mdpurchasefixedassetdebit;
              $journal->mjournalcredit = $d->mdpurchasefixedassetcredit;
              $journal->mjournalremark = "revisi";
              $journal->mdpayap_ref = "";
              $journal->mdpayar_ref = "";
              $journal->paymenttype = "system";
              $journal->save();

              // affect account saldo
              $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$journal->mjournalcoa)->first();
              $coa->saldo += $journal->mjournaldebit;
              $coa->saldo -= $journal->mjournalcredit;
              $coa->save();
            } else {
              // new data

              $d = new MDPurchaseFA;
              $d->setConnection(Auth::user()->db_name);
              $d->mhpurchasefixedassetno = $header->mhpurchasefixedassetno;
              $d->mdpurchasefixedassetdate = $header->mhpurchasefixedassetdate;
              $d->mdpurchasefixedassetcoacode = $detail['mdpurchasefixedassetcoacode'];
              $d->mdpurchasefixedassetcoaname = $detail['mdpurchasefixedassetcoaname'];
              $d->mdpurchasefixedassetdebit = preg_replace("/[^0-9]/", '', $detail['mdpurchasefixedassetdebit']);
              $d->mdpurchasefixedassetcredit = preg_replace("/[^0-9]/", '', $detail['mdpurchasefixedassetcredit']);
              $d->mdpurchasefixedassetjournalcode = $journal_id;
              $d->save();

              // add journal

              $journal = new MJournal;
              $journal->setConnection(Auth::user()->db_name);
              $journal->mjournalid = $journal_id;
              $journal->mjournaldate = $header->mhpurchasefixedassetdate;
              $journal->mjournaltransno = $header->mhpurchasefixedassetno;
              $journal->mjournaltranstype = 'purchase asset';
              $journal->mjournalcoa = $d->mdpurchasefixedassetcoacode;
              $journal->mjournaldebit = $d->mdpurchasefixedassetdebit;
              $journal->mjournalcredit = $d->mdpurchasefixedassetcredit;
              $journal->mjournalremark = "";
              $journal->mdpayap_ref = "";
              $journal->mdpayar_ref = "";
              $journal->paymenttype = "system";
              $journal->save();

              // affect account saldo
              $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$journal->mjournalcoa)->first();
              $coa->saldo += $journal->mjournaldebit;
              $coa->saldo -= $journal->mjournalcredit;
              $coa->save();
            }
        }

        DB::connection(Auth::user()->db_name)->commit();
        return "ok";
      } catch(\Exception $e){
        DB::connection(Auth::user()->db_name)->rollBack();
        return "err";
      }

    }

    public static function delete_transaction($id){
      DB::connection(Auth::user()->db_name)->beginTransaction();
      $header = MHPurchaseFA::on(Auth::user()->db_name)->where('id',$id)->first();
      try{
        $header->void = 1;
        $header->save();

        $details = MDPurchaseFA::on(Auth::user()->db_name)->where('mhpurchasefixedassetno',$header->mhpurchasefixedassetno)->get();
        foreach($details as $d){
          $d->void = 1;
          $coa = MCOA::on(Auth::user()->db_name)->where('mcoacode',$d->mdpurchasefixedassetcoacode)->first();
          $coa->saldo += $d->mdpurchasefixedassetcredit;
          $coa->saldo -= $d->mdpurchasefixedassetdebit;
          $coa->save();
          $d->save();
        }


        DB::connection(Auth::user()->db_name)->commit();
        return 'ok';
      } catch(\Exception $e){
        DB::connection(Auth::user()->db_name)->rollBack();
        return "err";
      }
    }
}
