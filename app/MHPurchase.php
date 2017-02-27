<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MConfig;
use Carbon\Carbon;
use Auth;
use DB;
use App\MGoods;
use App\MDPurchase;
use App\Helper\DBHelper;
use App\Helper\IntegrityHelper;
use App\MStockCard;
use App\MAPCard;
use App\MCOGS;
use App\HPPHistory;
use App\MJournal;
use App\MCOA;

class MHPurchase extends Model
{
    protected $table = 'mhpurchase';
    protected static function boot(){
  		parent::boot();
  		static::addGlobalScope('actives', function(Builder $builder) {
  				$builder->where('void', '=', 0);
                $builder->orderBy('mhpurchasedate','desc');
  		});
      static::created(function($mhpurchase){
        $mhpurchase->update_prefix_status();
      });
  	}

    public function update_prefix_status(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixpurchinvcount = $conf->msysprefixpurchinvcount+1;
      $conf->msysprefixpurchinvlastcount = $conf->get_last_count_format($conf->msysprefixpurchinvcount);
      $conf->save();
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      try{
        DBHelper::configureConnection(Auth::user()->db_alias);
        DB::connection(Auth::user()->db_name)->select(DB::raw('call autogen("mhpurchase","'.$conf->msysprefixpurchinv.'",'.$conf->msysprefixpurchinvcount.',"mhpurchaseno",'.$this->id.')'));
      } catch(Exception $e){
        var_dump($e);
        return $e;
      }
    }

    public function has_item_in_warehouses($warehouse_ids){
        $details = MDPurchase::on(Auth::user()->db_name)->where('mhpurchaseno',$this->mhpurchaseno)->whereIn('mdpurchasegoodsidwhouse',$warehouse_ids)->get()->toArray();
        return (sizeof($details) > 0);
    }

    public static function start_transaction($request){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{

            // fill the header info
            $trans_header = new MHPurchase;
            $trans_header->setConnection(Auth::user()->db_name);
            $trans_header->mhpurchaseno = "";
            $trans_header->mhpurchasedeliveryno = $request->do;
            $trans_header->mhpurchaseorderyno = $request->order;
            $trans_header->mhpurchasedate = Carbon::parse($request->date);
            $trans_header->mhpurchaseduedate = Carbon::parse($request->duedate);
            $trans_header->mhpurchasesupplierid = $request->msupplierid;
            $trans_header->mhpurchasesuppliername = $request->msuppliername;
            $trans_header->mhpurchasesubtotal = $request->subtotal + $request->discount;
            $trans_header->mhpurchasetaxtotal = $request->tax;
            $trans_header->mhpurchasediscounttotal = $request->discount;
            $trans_header->mhpurchasegrandtotal = $request->subtotal + $request->tax;
            $trans_header->mhpurchaseothertotal = 0;
            if($request->tax > 0){
              $trans_header->mhpurchasewithppn = 1;
            } else {
              $trans_header->mhpurchasewithppn = 0;
            }
            $trans_header->mhpurchaseremark = '';
            $trans_header->save();

            if($request->autogen == true){
                $trans_header->autogenproc();
            } else {
                $trans_header->mhpurchaseno = $request->no;
            }
            $header = MHPurchase::on(Auth::user()->db_name)->where('id',$trans_header->id)->first();

            $coa_persediaan = MCOA::on(Auth::user()->db_name)->where('mcoacode',"1105.01")->first();
            $coa_ppn = MCOA::on(Auth::user()->db_name)->where('mcoacode',"1107.01")->first();
            $coa_hutang = MCOA::on(Auth::user()->db_name)->where('mcoacode',"2101.03")->first();

            // add journal
            MJournal::record_journal($header->mhpurchaseno,"Pembelian","1105.01",$header->mhpurchasesubtotal,0,"","","");
            MJournal::record_journal($header->mhpurchaseno,"Pembelian","1107.01",$header->mhpurchasetaxtotal,0,"","","");
            MJournal::record_journal($header->mhpurchaseno,"Pembelian","2101.03",0,$header->mhpurchasegrandtotal,"","","");

            MJournal::add_prefix();

            $coa_persediaan->update_saldo('+',$header->mhpurchasesubtotal);
            $coa_ppn->update_saldo('+',$header->mhpurchasetaxtotal);
            $coa_hutang->update_saldo('+',$header->mhpurchasegrandtotal);

            // fill the detail info
            foreach($request->goods as $g){
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g['goods']['mgoodscode'])->first();

                $mgoods->mgoodspricein = $g['buy_price'];
                $mgoods->save();
                $last_stock = $mgoods->mgoodsstock;

                $detail = new MDPurchase;
                $detail->setConnection(Auth::user()->db_name);
                $detail->mhpurchaseno = $header->mhpurchaseno;
                $detail->mdpurchasesupplierid = $header->mhpurchasesupplierid;
                $detail->mdpurchasesuppliername = $header->mhpurchasesuppliername;
                $detail->mdpurchasedate = $header->mhpurchasedate;
                $detail->mdpurchasegoodsid = $mgoods->mgoodscode;
                $detail->mdpurchasegoodsname = $mgoods->mgoodsname;
                $detail->mdpurchasegoodsid = $g['goods']['mgoodscode'];
                $detail->mdpurchasegoodsname = $g['goods']['mgoodsname'];
                $detail->mdpurchasegoodsunit3 = $g['detail_goods_unit3'];
                $detail->mdpurchasegoodsunit3conv = $g['detail_goods_unit3_conv'];
                $detail->mdpurchasegoodsunit3label = $g['detail_goods_unit3_label'];
                $detail->mdpurchasegoodsunit2 = $g['detail_goods_unit2'];
                $detail->mdpurchasegoodsunit2conv = $g['detail_goods_unit2_conv'];
                $detail->mdpurchasegoodsunit2label = $g['detail_goods_unit2_label'];
                $detail->mdpurchasegoodsunit1 = $g['detail_goods_unit1'];
                $detail->mdpurchasegoodsunit1conv = $g['detail_goods_unit1_conv'];
                $detail->mdpurchasegoodsunit1label = $g['detail_goods_unit1_label'];
                $detail->mdpurchasegoodsqty = $g['usage'];
                $detail->mdpurchasegoodsprice = $g['goods']['mgoodspriceout'];
                $detail->mdpurchasegoodsgrossamount = $g['subtotal'];
                $detail->mdpurchasegoodsdiscount = $g['disc'];
                $detail->mdpurchasegoodsidwhouse = $g['warehouse'];
                $detail->mdpurchasebuyprice = $g['buy_price'];
                $detail->mdpurchasetax = $g['tax'];
                $detail->mdpurchaseremarks = $g['remark'];
                $detail->save();

                // update stock card
                $stock_card = new MStockCard;
                $stock_card->setConnection(Auth::user()->db_name);
                $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
                $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
                $stock_card->mstockcarddate = Carbon::parse($request->date);
                $stock_card->mstockcardtranstype = $request->type;
                $stock_card->mstockcardtransno = $header->mhpurchaseno;
                $stock_card->mstockcardremark = "Transaksi ".$request->type." oleh ".Auth::user()->name."/".Auth::user()->id." ".$g['remark'];
                $stock_card->mstockcardstockin = $g['usage'];
                $stock_card->mstockcardstockout = 0;
                // $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
                // this process also effects to $mgoods->mgoodsstock value;
                $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock += $g['usage'];
                $stock_card->mstockcardwhouse = $g['warehouse'];
                $stock_card->mstockcarduserid = Auth::user()->id;
                $stock_card->mstockcardusername = Auth::user()->name;
                $stock_card->mstockcardeventdate = Carbon::now();
                $stock_card->mstockcardeventtime = Carbon::now();
                $stock_card->edited = 0;
                $stock_card->save();
                $mgoods->save();

                // update stock reference untuk deleting
                $detail->stock_ref = $stock_card->id;
                $detail->save();

                // update COGS
                $detail->cogs_ref = IntegrityHelper::calculateCOGS($mgoods,$detail->mdpurchasegoodsgrossamount);
                $detail->save();


                // find first cogs
                // $goods_cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
                // $current_cogs = 0;
                // if($goods_cogs == null){
                //     $cogs = new MCOGS;
                //     $cogs->setConnection(Auth::user()->db_name);
                //     $cogs->mcogsgoodscode = $mgoods->mgoodscode;
                //     $cogs->mcogsgoodsname = $mgoods->mgoodsname;
                //     $cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                //     $cogs->mcogslastcogs = $detail->mdpurchasegoodsgrossamount / $mgoods->mgoodsstock;
                //     $cogs->mcogsremarks = "";
                //     $cogs->save();
                //     $current_cogs = $cogs->mcogslastcogs;
                // } else {
                //     // update cogs
                //     $goods_cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                //     $cogs_num = (($last_stock * $goods_cogs->mcogslastcogs) + $detail->mdpurchasegoodsgrossamount ) / $mgoods->mgoodsstock;
                //     $goods_cogs->mcogslastcogs = $cogs_num;
                //     $goods_cogs->mcogsremarks = "";
                //     $goods_cogs->save();
                //     $current_cogs = $goods_cogs->mcogslastcogs;
                // }
                //
                // // save cogs log
                // $h = new HPPHistory;
                // $h->setConnection(Auth::user()->db_name);
                // $h->hpphistorygoodsid = $mgoods->mgoodscode;
                // $h->hpphistorypurchase = $detail->mdpurchasegoodsgrossamount;
                // $h->hpphistoryqty = $detail->mdpurchasegoodsqty;
                // $h->hpphistorycogs = $current_cogs;
                // $h->hpphistoryremarks = "";
                // $h->save();
                //
                // $detail->cogs_ref = $h->id;
                // $detail->save();
            }

            // fill the AP
            $ap = new MAPCard;
            $ap->setConnection(Auth::user()->db_name);
            $ap->mapcardsupplierid = $request->msupplierid;
            $ap->mapcardsuppliername = $request->msuppliername;
            $ap->mapcardtdate = Carbon::parse($request->date);
            $ap->mapcardduedate = Carbon::parse($request->duedate);
            $ap->mapcardtransno = $header->mhpurchaseno;
            $ap->mapcardremark = "";
            $ap->mapcardtotalinv = $header->mhpurchasegrandtotal;
            $ap->mapcardpayamount = 0;
            $ap->mapcardoutstanding = $header->mhpurchasegrandtotal;
            $ap->mapcarduserid = Auth::user()->id;
            $ap->mapcardusername = Auth::user()->name;
            $ap->mapcardeventdate = Carbon::now();
            $ap->mapcardeventtime = Carbon::now();
            $ap->mapcardwarehouseid = $g['warehouse'];
            $ap->save();

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';
        } catch (\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return 'err';
        }
    }

    public static function update_transaction($id,$request){

        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{
            // update header data

            $trans_header = MHPurchase::on(Auth::user()->db_name)->where('id',$id)->first();

            $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
            $coa = $conf->msyspayapaccount;
            $coa_ap = MCOA::on(Auth::user()->db_name)->where('mcoacode',$coa)->first();

            $should_calculate_cogs_again = false;

            $coa_ap->update_saldo("-",$trans_header->mhpurchasegrandtotal);

            $trans_header->mhpurchasedeliveryno = $request->do;
            $trans_header->mhpurchaseorderyno = $request->order;
            $trans_header->mhpurchasedate = Carbon::parse($request->date);
            $trans_header->mhpurchaseduedate = Carbon::parse($request->duedate);
            $trans_header->mhpurchasesupplierid = $request->msupplierid;
            $trans_header->mhpurchasesuppliername = $request->msuppliername;
            $trans_header->mhpurchasesubtotal = $request->subtotal + $request->discount;
            $trans_header->mhpurchasetaxtotal = $request->tax;
            $trans_header->mhpurchasediscounttotal = $request->discount;
            $trans_header->mhpurchasegrandtotal = $request->subtotal + $request->tax;
            $trans_header->mhpurchaseothertotal = 0;
            if($request->tax > 0){
              $trans_header->mhpurchasewithppn = 1;
            } else {
              $trans_header->mhpurchasewithppn = 0;
            }
            $trans_header->mhpurchaseremark = '';
            $trans_header->save();

            // update journal

            $coa_persediaan = MCOA::on(Auth::user()->db_name)->where('mcoacode',"1105.01")->first();
            $coa_ppn = MCOA::on(Auth::user()->db_name)->where('mcoacode',"1107.01")->first();
            $coa_hutang = MCOA::on(Auth::user()->db_name)->where('mcoacode',"2101.03")->first();

            $journal_persediaan = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$trans_header->mhpurchaseno)->where('mjournalcoa',"1105.01")->first();
            $journal_ppn = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$trans_header->mhpurchaseno)->where('mjournalcoa',"1107.01")->first();
            $journal_hutang = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$trans_header->mhpurchaseno)->where('mjournalcoa',"2101.03")->first();

            $coa_persediaan->update_saldo('-',$journal_persediaan->mjournaldebit);
            $coa_ppn->update_saldo('-',$journal_ppn->mjournaldebit);
            $coa_hutang->update_saldo('-',$journal_hutang->mjournalcredit);

            $journal_persediaan->mjournaldebit = $trans_header->mhpurchasesubtotal;
            $journal_persediaan->save();
            $journal_ppn->mjournaldebit = $trans_header->mhpurchasetaxtotal;
            $journal_ppn->save();
            $journal_hutang->mjournalcredit = $trans_header->mhpurchasegrandtotal;
            $journal_hutang->save();

            $coa_persediaan->update_saldo('+',$trans_header->mhpurchasesubtotal);
            $coa_ppn->update_saldo('+',$trans_header->mhpurchasetaxtotal);
            $coa_hutang->update_saldo('+',$trans_header->mhpurchasegrandtotal);

            // loop new details
            // void them all
            $details = MDPurchase::on(Auth::user()->db_name)->where('mhpurchaseno',$trans_header->mhpurchaseno)->get();
            foreach ($details as $dt) {
              $dt->void = 1;
              $dt->save();
            }

            foreach ($request->goods as $g) {
                $invoice_detail = MDPurchase::on(Auth::user()->db_name)->where('mdpurchasegoodsid',$g['goods']['mgoodscode'])->where('mhpurchaseno',$trans_header->mhpurchaseno)->first();
                // var_dump($invoice_detail);
                if($invoice_detail != null ){
                    $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g['goods']['mgoodscode'])->first();
                    $mgoods->mgoodspricein = $g['buy_price'];
                    $mgoods->save();
                    $last_stock = MStockCard::on(Auth::user()->db_name)->where('mstockcardtransno',$trans_header->mhpurchaseno)->where('mstockcardgoodsid',$mgoods->mgoodscode)->orderBy('created_at','desc')->get()->first();
                    $old_qty = $invoice_detail->mdpurchasegoodsqty;

                    $old_detail = $invoice_detail;
                    $old_price = $old_detail->mdpurchasebuyprice;
                    // update detail data
                    $invoice_detail->mhpurchaseno = $trans_header->mhpurchaseno;
                    $invoice_detail->mdpurchasesupplierid = $trans_header->mhpurchasesupplierid;
                    $invoice_detail->mdpurchasesuppliername = $trans_header->mhpurchasesuppliername;
                    $invoice_detail->mdpurchasedate = $trans_header->mhpurchasedate;
                    $invoice_detail->mdpurchasegoodsid = $mgoods->mgoodscode;
                    $invoice_detail->mdpurchasegoodsname = $mgoods->mgoodsname;
                    $invoice_detail->mdpurchasegoodsid = $g['goods']['mgoodscode'];
                    $invoice_detail->mdpurchasegoodsname = $g['goods']['mgoodsname'];
                    $invoice_detail->mdpurchasegoodsunit3 = $g['detail_goods_unit3'];
                    $invoice_detail->mdpurchasegoodsunit3conv = $g['detail_goods_unit3_conv'];
                    $invoice_detail->mdpurchasegoodsunit3label = $g['detail_goods_unit3_label'];
                    $invoice_detail->mdpurchasegoodsunit2 = $g['detail_goods_unit2'];
                    $invoice_detail->mdpurchasegoodsunit2conv = $g['detail_goods_unit2_conv'];
                    $invoice_detail->mdpurchasegoodsunit2label = $g['detail_goods_unit2_label'];
                    $invoice_detail->mdpurchasegoodsunit1 = $g['detail_goods_unit1'];
                    $invoice_detail->mdpurchasegoodsunit1conv = $g['detail_goods_unit1_conv'];
                    $invoice_detail->mdpurchasegoodsunit1label = $g['detail_goods_unit1_label'];
                    $invoice_detail->mdpurchasegoodsqty = $g['usage'];
                    $invoice_detail->mdpurchasegoodsprice = $g['goods']['mgoodspriceout'];
                    $invoice_detail->mdpurchasegoodsgrossamount = $g['subtotal'];
                    $invoice_detail->mdpurchasegoodsdiscount = $g['disc'];
                    $invoice_detail->mdpurchasegoodsidwhouse = $g['warehouse'];
                    $invoice_detail->mdpurchasebuyprice = $g['buy_price'];
                    $invoice_detail->mdpurchasetax = $g['tax'];
                    $invoice_detail->mdpurchaseremarks = '';
                    $invoice_detail->void = 0;
                    $invoice_detail->save();

                    // if qty still same but price changed
                    if(($old_qty == $g['usage']) && ($old_price != $g['buy_price'])){
                        $invoice_detail->cogs_ref = IntegrityHelper::updateCOGS($mgoods,$invoice_detail->mdpurchasegoodsgrossamount,$g['usage']);
                        $invoice_detail->save();
                        $should_calculate_cogs_again = true;
                    }


                    // update stock card
                    if($old_qty != $g['usage']){
                        $should_calculate_cogs_again = true;
                        //out dengan qty lama
                        $stock_card = new MStockCard;
                        $stock_card->setConnection(Auth::user()->db_name);
                        $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
                        $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
                        $stock_card->mstockcarddate = Carbon::parse($request->date);
                        $stock_card->mstockcardtranstype = $request->type;
                        $stock_card->mstockcardtransno = $trans_header->mhpurchaseno;
                        $stock_card->mstockcardremark = "Revisi Transaksi ".$request->type." oleh ".Auth::user()->name."/".Auth::user()->id." ".$g['remark'];
                        $stock_card->mstockcardstockin = 0;
                        $stock_card->mstockcardstockout = $old_qty;
                        // $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
                        $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock -= $old_qty;
                        $stock_card->mstockcardwhouse = $g['warehouse'];
                        $stock_card->mstockcarduserid = Auth::user()->id;
                        $stock_card->mstockcardusername = Auth::user()->name;
                        $stock_card->mstockcardeventdate = Carbon::now();
                        $stock_card->mstockcardeventtime = Carbon::now();
                        $stock_card->edited = 1;
                        $stock_card->void = 0;
                        $stock_card->save();

                        if($old_qty != $g['usage']){
                        //   $mgoods->mgoodsstock -= $last_stock->mstockcardstockin;
                        }
                        $mgoods->save();

                        // reset COGS
                        // $last_cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
                        // $ref_cogs = HPPHistory::on(Auth::user()->db_name)->where('id',$invoice_detail->cogs_ref)->first();
                        // if($mgoods->mgoodsstock == 0){
                        //     $cogs_num = 0;
                        // } else {
                        //     $cogs_num = (($last_cogs->mcogslastcogs * $last_cogs->mcogsgoodstotalqty) - $ref_cogs->hpphistorypurchase) / $mgoods->mgoodsstock;
                        // }
                        //
                        // $h = new HPPHistory;
                        // $h->setConnection(Auth::user()->db_name);
                        // $h->hpphistorygoodsid = $mgoods->mgoodscode;
                        // $h->hpphistorypurchase = 0;
                        // $h->hpphistoryqty = $mgoods->mgoodsstock;
                        // $h->hpphistorycogs = $cogs_num;
                        // $h->hpphistoryremarks = "Revisi pembelian";
                        // $h->save();
                        //
                        // $goods_cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
                        // $goods_cogs->mcogslastcogs = $cogs_num;
                        // $goods_cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                        // $goods_cogs->save();

                        // in dengan yg baru
                        $stock_card = new MStockCard;
                        $stock_card->setConnection(Auth::user()->db_name);
                        $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
                        $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
                        $stock_card->mstockcarddate = Carbon::parse($request->date);
                        $stock_card->mstockcardtranstype = $request->type;
                        $stock_card->mstockcardtransno = $trans_header->mhpurchaseno;
                        $stock_card->mstockcardremark = "Revisi Transaksi ".$request->type." oleh ".Auth::user()->name."/".Auth::user()->id." ".$g['remark'];
                        $stock_card->mstockcardstockin = $g['usage'];
                        $stock_card->mstockcardstockout = 0;
                        $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock += $g['usage'];
                        $stock_card->mstockcardwhouse = $g['warehouse'];
                        $stock_card->mstockcarduserid = Auth::user()->id;
                        $stock_card->mstockcardusername = Auth::user()->name;
                        $stock_card->mstockcardeventdate = Carbon::now();
                        $stock_card->mstockcardeventtime = Carbon::now();
                        $stock_card->edited = 1;
                        $stock_card->void = 0;
                        $stock_card->save();

                        $last_stock = $mgoods->mgoodsstock;
                        $mgoods->mgoodsstock += $g['usage'];
                        $mgoods->save();

                        // $cogs_num = (($last_stock * $goods_cogs->mcogslastcogs) + $invoice_detail->mdpurchasegoodsgrossamount ) / $mgoods->mgoodsstock;
                        // $goods_cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                        // $goods_cogs->mcogslastcogs = $cogs_num;
                        // $goods_cogs->mcogsremarks = "";
                        // $goods_cogs->save();
                        //
                        // $h = new HPPHistory;
                        // $h->setConnection(Auth::user()->db_name);
                        // $h->hpphistorygoodsid = $mgoods->mgoodscode;
                        // $h->hpphistorypurchase = $invoice_detail->mdpurchasegoodsgrossamount;
                        // $h->hpphistoryqty = $mgoods->mgoodsstock;
                        // $h->hpphistorycogs = $cogs_num;
                        // $h->hpphistoryremarks = "Revisi pembelian";
                        // $h->save();

                        // update detail reference
                        $invoice_detail->stock_ref = $stock_card->id;
                        $invoice_detail->cogs_ref = IntegrityHelper::updateCOGS($mgoods,$invoice_detail->mdpurchasegoodsgrossamount);
                        $invoice_detail->save();

                    }
                } else {
                    // new data
                    $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g['goods']['mgoodscode'])->first();

                    $mgoods->mgoodspricein = $g['buy_price'];
                    $mgoods->save();

                    $detail = new MDPurchase;
                    $detail->setConnection(Auth::user()->db_name);
                    $detail->mhpurchaseno = $trans_header->mhpurchaseno;
                    $detail->mdpurchasesupplierid = $trans_header->mhpurchasesupplierid;
                    $detail->mdpurchasesuppliername = $trans_header->mhpurchasesuppliername;
                    $detail->mdpurchasedate = $trans_header->mhpurchasedate;
                    $detail->mdpurchasegoodsid = $mgoods->mgoodscode;
                    $detail->mdpurchasegoodsname = $mgoods->mgoodsname;
                    $detail->mdpurchasegoodsid = $g['goods']['mgoodscode'];
                    $detail->mdpurchasegoodsname = $g['goods']['mgoodsname'];
                    $detail->mdpurchasegoodsunit3 = $g['detail_goods_unit3'];
                    $detail->mdpurchasegoodsunit3conv = $g['detail_goods_unit3_conv'];
                    $detail->mdpurchasegoodsunit3label = $g['detail_goods_unit3_label'];
                    $detail->mdpurchasegoodsunit2 = $g['detail_goods_unit2'];
                    $detail->mdpurchasegoodsunit2conv = $g['detail_goods_unit2_conv'];
                    $detail->mdpurchasegoodsunit2label = $g['detail_goods_unit2_label'];
                    $detail->mdpurchasegoodsunit1 = $g['detail_goods_unit1'];
                    $detail->mdpurchasegoodsunit1conv = $g['detail_goods_unit1_conv'];
                    $detail->mdpurchasegoodsunit1label = $g['detail_goods_unit1_label'];
                    $detail->mdpurchasegoodsqty = $g['usage'];
                    $detail->mdpurchasegoodsprice = $g['goods']['mgoodspriceout'];
                    $detail->mdpurchasegoodsgrossamount = $g['subtotal'];
                    $detail->mdpurchasegoodsdiscount = $g['disc'];
                    $detail->mdpurchasegoodsidwhouse = $g['warehouse'];
                    $detail->mdpurchasebuyprice = $g['buy_price'];
                    $detail->save();

                    // update stock card
                    $stock_card = new MStockCard;
                    $stock_card->setConnection(Auth::user()->db_name);
                    $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
                    $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
                    $stock_card->mstockcarddate = Carbon::parse($request->date);
                    $stock_card->mstockcardtranstype = $request->type;
                    $stock_card->mstockcardtransno = $trans_header->mhpurchaseno;
                    $stock_card->mstockcardremark = "Transaksi ".$request->type." oleh ".Auth::user()->name."/".Auth::user()->id." ".$g['remark'];
                    $stock_card->mstockcardstockin = $g['usage'];
                    $stock_card->mstockcardstockout = 0;
                    $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
                    $stock_card->mstockcardwhouse = $g['warehouse'];
                    $stock_card->mstockcarduserid = Auth::user()->id;
                    $stock_card->mstockcardusername = Auth::user()->name;
                    $stock_card->mstockcardeventdate = Carbon::now();
                    $stock_card->mstockcardeventtime = Carbon::now();
                    $stock_card->edited = 0;
                    $stock_card->save();

                    // update goods
                    $last_stock = $mgoods->mgoodsstock;
                    $mgoods->mgoodsstock += $g['usage'];
                    $mgoods->save();

                    // update COGS
                    // find first cogs
                    // $goods_cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
                    // $current_cogs = 0;
                    // if($goods_cogs == null){
                    //     $cogs = new MCOGS;
                    //     $cogs->setConnection(Auth::user()->db_name);
                    //     $cogs->mcogsgoodscode = $mgoods->mgoodscode;
                    //     $cogs->mcogsgoodsname = $mgoods->mgoodsname;
                    //     $cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                    //     $cogs->mcogslastcogs = $header->mhpurchasegrandtotal / $mgoods->mgoodsstock;
                    //     $cogs->mcogsremarks = "";
                    //     $cogs->save();
                    //     $current_cogs = $cogs->mcogslastcogs;
                    // } else {
                    //     // update cogs
                    //     $goods_cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                    //     $cogs_num = (($last_stock * $goods_cogs->mcogslastcogs) + $detail->mdpurchasegoodsgrossamount ) / $mgoods->mgoodsstock;
                    //     $goods_cogs->mcogslastcogs = $cogs_num;
                    //     $goods_cogs->mcogsremarks = "";
                    //     $goods_cogs->save();
                    //     $current_cogs = $goods_cogs->mcogslastcogs;
                    // }
                    //
                    // // save cogs log
                    // $h = new HPPHistory;
                    // $h->setConnection(Auth::user()->db_name);
                    // $h->hpphistorygoodsid = $mgoods->mgoodscode;
                    // $h->hpphistorypurchase = $detail->mdpurchasegoodsgrossamount;
                    // $h->hpphistoryqty = $detail->mdpurchasegoodsqty;
                    // $h->hpphistorycogs = $current_cogs;
                    // $h->hpphistoryremarks = "";
                    // $h->save();

                    $invoice_detail->cogs_ref = IntegrityHelper::updateCOGS($mgoods,$invoice_detail->mdpurchasegoodsgrossamount);
                    $invoice_detail->save();
                }
            }

            // update ap data
            $ap = MAPCard::on(Auth::user()->db_name)->where('mapcardsupplierid',$trans_header->mhpurchasesupplierid)->where('mapcardtransno',$trans_header->mhpurchaseno)->first();
            $ap->mapcardsupplierid = $request->msupplierid;
            $ap->mapcardsuppliername = $request->msuppliername;
            $ap->mapcardtdate = Carbon::parse($request->date);
            $ap->mapcardduedate = Carbon::parse($request->duedate);
            $ap->mapcardtransno = $trans_header->mhpurchaseno;
            $ap->mapcardremark = "Editing";
            $ap->mapcardtotalinv = $trans_header->mhpurchasegrandtotal;
            $ap->mapcardpayamount = 0;
            $ap->mapcardoutstanding = $trans_header->mhpurchasegrandtotal;
            $ap->mapcarduserid = Auth::user()->id;
            $ap->mapcardusername = Auth::user()->name;
            $ap->mapcardeventdate = Carbon::now();
            $ap->mapcardeventtime = Carbon::now();
            $ap->save();

            // voided details
            $voided_details = MDPurchase::on(Auth::user()->db_name)->where('void',1)->get();
            foreach($voided_details as $v){
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$v->mdpurchasegoodsid)->first();
                //out dengan qty lama
                $stock_card = new MStockCard;
                $stock_card->setConnection(Auth::user()->db_name);
                $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
                $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
                $stock_card->mstockcarddate = Carbon::parse($request->date);
                $stock_card->mstockcardtranstype = $request->type;
                $stock_card->mstockcardtransno = $trans_header->mhpurchaseno;
                $stock_card->mstockcardremark = "Editing Transaksi Hapus item".$request->type." oleh ".Auth::user()->name."/".Auth::user()->id." ";;
                $stock_card->mstockcardstockin =  0;
                $stock_card->mstockcardstockout = $v->mdpurchasegoodsqty;
                $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock - $v->mdpurchasegoodsqty;
                $stock_card->mstockcardwhouse = $g['warehouse'];
                $stock_card->mstockcarduserid = Auth::user()->id;
                $stock_card->mstockcardusername = Auth::user()->name;
                $stock_card->mstockcardeventdate = Carbon::now();
                $stock_card->mstockcardeventtime = Carbon::now();
                $stock_card->save();
            }

            // $journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$trans_header->mhpurchaseno)->where('mjournaltranstype','Pembelian')->first();
            // $journal->mjournalcredit = $trans_header->mhpurchasegrandtotal;
            // $journal->save();
            //
            // $coa_ap->update_saldo("+",$trans_header->mhpurchasegrandtotal);
            if($should_calculate_cogs_again){
                IntegrityHelper::recalculateTransactionFrom($request->date);
            }

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';
        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return 'err';
        }
    }

    public static function delete_transaction($id){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{
            $header = MHPurchase::on(Auth::user()->db_name)->where('id',$id)->first();

            $details = MDPurchase::on(Auth::user()->db_name)->where('mhpurchaseno',$header->mhpurchaseno)->get();

            $coa_persediaan = MCOA::on(Auth::user()->db_name)->where('mcoacode',"1105.01")->first();
            $coa_ppn = MCOA::on(Auth::user()->db_name)->where('mcoacode',"1107.01")->first();
            $coa_hutang = MCOA::on(Auth::user()->db_name)->where('mcoacode',"2101.03")->first();

            $journal_persediaan = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhpurchaseno)->where('mjournalcoa',"1105.01")->first();
            $journal_ppn = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhpurchaseno)->where('mjournalcoa',"1107.01")->first();
            $journal_hutang = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhpurchaseno)->where('mjournalcoa',"2101.03")->first();

            $coa_persediaan->update_saldo('-',$journal_persediaan->mjournaldebit);
            $coa_ppn->update_saldo('-',$journal_ppn->mjournaldebit);
            $coa_hutang->update_saldo('-',$journal_hutang->mjournalcredit);

            MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhpurchaseno)->delete();

            // void all details and return the stock
            foreach($details as $detail){
                $detail->void = 1;
                $detail->save();

                $stock_ref = MStockCard::on(Auth::user()->db_name)->where('id',$detail->stock_ref)->first();
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$detail->mdpurchasegoodsid)->first();

                // create deletion stock
                $stock_card = new MStockCard;
                $stock_card->setConnection(Auth::user()->db_name);
                $stock_card->mstockcardgoodsid = $stock_ref->mstockcardgoodsid;
                $stock_card->mstockcardgoodsname = $stock_ref->mstockcardgoodsname;
                $stock_card->mstockcarddate = Carbon::now();
                $stock_card->mstockcardtranstype = 'Pembatalan transaksi';
                $stock_card->mstockcardtransno = $header->mhpurchaseno;
                $stock_card->mstockcardremark = "Pembatalan transaksi oleh ".Auth::user()->name."/".Auth::user()->id;
                $stock_card->mstockcardstockin = 0;
                $stock_card->mstockcardstockout = $stock_ref->mstockcardstockin;
                $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
                $stock_card->mstockcardwhouse = $stock_ref->mstockcardwhouse;
                $stock_card->mstockcarduserid = Auth::user()->id;
                $stock_card->mstockcardusername = Auth::user()->name;
                $stock_card->mstockcardeventdate = Carbon::now();
                $stock_card->mstockcardeventtime = Carbon::now();
                $stock_card->edited = 0;
                $stock_card->save();

                // update goods stock
                $last_stock = $mgoods->mgoodsstock;
                $last_stock -= $stock_card->mstockcardstockout;

                // check if deletion cause minus
                if($last_stock < 0){
                    DB::connection(Auth::user()->db_name)->rollBack();
                    return 'empty';
                }

                $mgoods->mgoodsstock = $last_stock;
                $mgoods->save();

                $ref_cogs = HPPHistory::on(Auth::user()->db_name)->where('id',$detail->cogs_ref)->first();

                // reset COGS
                // // $last_cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
                // // $ref_cogs = HPPHistory::on(Auth::user()->db_name)->where('id',$detail->cogs_ref)->first();
                // // if($mgoods->mgoodsstock == 0){
                // //     $cogs_num = 0;
                // // } else {
                // //     $cogs_num = (($last_cogs->mcogslastcogs * $last_cogs->mcogsgoodstotalqty) - $ref_cogs->hpphistorypurchase) / $mgoods->mgoodsstock;
                // // }
                // //
                // // $h = new HPPHistory;
                // // $h->setConnection(Auth::user()->db_name);
                // // $h->hpphistorygoodsid = $mgoods->mgoodscode;
                // // $h->hpphistorypurchase = 0;
                // // $h->hpphistoryqty = $mgoods->mgoodsstock;
                // // $h->hpphistorycogs = $cogs_num;
                // // $h->hpphistoryremarks = "Void pembelian";
                // // $h->save();
                //
                // $goods_cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
                // $goods_cogs->mcogslastcogs = $cogs_num;
                // $goods_cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                // $goods_cogs->save();

                IntegrityHelper::deleteCOGS($mgoods,$ref_cogs->hpphistorypurchase,'void');

                // void APCard;
                $ap = MAPCard::on(Auth::user()->db_name)->where('mapcardtransno',$detail->mhpurchaseno)->first();
                $ap->void = 1;
                $ap->save();

                // $journal = MJournal::on(Auth::user()->db_name)->where('mjournaltransno',$header->mhpurchaseno)->where('mjournaltranstype','Pembelian')->first();
                // $journal->void = 1;
                // $journal->save();

                $header->void = 1;
                $header->save();

            }

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';

        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return 'err';
        }
    }
}
