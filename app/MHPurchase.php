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
use App\MStockCard;
use App\MAPCard;
use App\MCOGS;

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

    public static function start_transaction($request){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{

            // fill the header info
            $trans_header = new MHPurchase;
            $trans_header->setConnection(Auth::user()->db_name);
            $trans_header->mhpurchaseno = "";
            $trans_header->mhpurchasedeliveryno = "";
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

            // fill the detail info
            foreach($request->goods as $g){
                $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g['goods']['mgoodscode'])->first();

                $mgoods->mgoodspricein = $g['buy_price'];
                $mgoods->save();

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
                $detail->save();

                // update stock card
                $stock_card = new MStockCard;
                $stock_card->setConnection(Auth::user()->db_name);
                $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
                $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
                $stock_card->mstockcarddate = Carbon::parse($request->date);
                $stock_card->mstockcardtranstype = $request->type;
                $stock_card->mstockcardtransno = $header->mhpurchaseno;
                $stock_card->mstockcardremark = "Transaksi ".$request->type." untuk ";
                $stock_card->mstockcardstockin = $g['usage'];
                $stock_card->mstockcardstockout = 0;
                $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
                $stock_card->mstockcardwhouse = $g['warehouse'];
                $stock_card->mstockcarduserid = Auth::user()->id;
                $stock_card->mstockcardusername = Auth::user()->name;
                $stock_card->mstockcardeventdate = Carbon::now();
                $stock_card->mstockcardeventtime = Carbon::now();
                $stock_card->edited = 0;
                // $stock_card->mstockcardunit3 = $mgoods->mgoodscurrentunit3;
                // $stock_card->mstockcardunit3conv = $mgoods->mgoodscurrentunit3conv;
                // $stock_card->mstockcardunit3label = $mgoods->mgoodscurrentunit3label;
                // $stock_card->mstockcardunit2 = $mgoods->mgoodscurrentunit2;
                // $stock_card->mstockcardunit2conv = $mgoods->mgoodscurrentunit2conv;
                // $stock_card->mstockcardunit2label = $mgoods->mgoodscurrentunit2label;
                // $stock_card->mstockcardunit1 = $mgoods->mgoodscurrentunit1;
                // $stock_card->mstockcardunit1conv = $mgoods->mgoodscurrentunit1conv;
                // $stock_card->mstockcardunit1label = $mgoods->mgoodscurrentunit1label;
                // in conversion
                // $stock_card->mstockcardinunit3 = $g['detail_goods_unit3'];
                // $stock_card->mstockcardinunit3conv = $g['detail_goods_unit3_conv'];
                // $stock_card->mstockcardinunit3label = $g['detail_goods_unit3_label'];
                // $stock_card->mstockcardinunit2 = $g['detail_goods_unit2'];
                // $stock_card->mstockcardinunit2conv = $g['detail_goods_unit2_conv'];
                // $stock_card->mstockcardinunit2label = $g['detail_goods_unit2_label'];
                // $stock_card->mstockcardinunit1 = $g['detail_goods_unit1'];
                // $stock_card->mstockcardinunit1conv = $g['detail_goods_unit1_conv'];
                // $stock_card->mstockcardinunit1label = $g['detail_goods_unit1_label'];
                $stock_card->save();

                // update goods
                $last_stock = $mgoods->mgoodsstock;
                $mgoods->mgoodsstock += $g['usage'];
                // $mgoods->mgoodscurrentunit3 += $g['detail_goods_unit3'];
                // $mgoods->mgoodscurrentunit3conv = $g['detail_goods_unit3_conv'];
                // $mgoods->mgoodscurrentunit3label = $g['detail_goods_unit3_label'];
                // $mgoods->mgoodscurrentunit2 += $g['detail_goods_unit2'];
                // $mgoods->mgoodscurrentunit2conv = $g['detail_goods_unit2_conv'];
                // $mgoods->mgoodscurrentunit2label = $g['detail_goods_unit2_label'];
                // $mgoods->mgoodscurrentunit1 += $g['detail_goods_unit1'];
                // $mgoods->mgoodscurrentunit1conv = $g['detail_goods_unit1_conv'];
                // $mgoods->mgoodscurrentunit1label = $g['detail_goods_unit1_label'];
                $mgoods->save();

                // update stock reference untuk deleting
                $detail->stock_ref = $stock_card->id;
                $detail->save();

                // update COGS
                // find first cogs
                $goods_cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
                if($goods_cogs == null){
                    $cogs = new MCOGS;
                    $cogs->setConnection(Auth::user()->db_name);
                    $cogs->mcogsgoodscode = $mgoods->mgoodscode;
                    $cogs->mcogsgoodsname = $mgoods->mgoodsname;
                    $cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                    $cogs->mcogslastcogs = $header->mhpurchasegrandtotal / $mgoods->mgoodsstock;
                    $cogs->mcogsremarks = "";
                    $cogs->save();
                } else {
                    // update cogs
                    $goods_cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                    $cogs_num = (($last_stock * $goods_cogs->mcogslastcogs) + $header->mhpurchasegrandtotal ) / $mgoods->mgoodsstock;
                    $goods_cogs->mcogslastcogs = $cogs_num;
                    $goods_cogs->mcogsremarks = "";
                    $goods_cogs->save();
                }
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

            // loop new details
            // void them all
            $details = MDPurchase::on(Auth::user()->db_name)->where('mhpurchaseno',$trans_header->mhpurchaseno)->get();
            foreach ($details as $dt) {
              $dt->void = 1;
              $dt->save();
            }

            foreach ($request->goods as $g) {
                $invoice_detail = MDPurchase::on(Auth::user()->db_name)->where('mdpurchasegoodsid',$g['goods']['mgoodscode'])->where('mhpurchaseno',$trans_header->mhpurchaseno)->first();

                if($invoice_detail != null ){
                    $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g['goods']['mgoodscode'])->first();
                    $mgoods->mgoodspricein = $g['buy_price'];
                    $mgoods->save();
                    $last_stock = MStockCard::on(Auth::user()->db_name)->where('mstockcardtransno',$trans_header->mhpurchaseno)->where('mstockcardgoodsid',$mgoods->mgoodscode)->orderBy('created_at','desc')->get()->first();
                    $old_qty = $invoice_detail->mdpurchasegoodsqty;
                    // dd($old_qty);
                    $old_detail = $invoice_detail;
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
                    $invoice_detail->void = 0;
                    $invoice_detail->save();

                    // update stock card
                    if($old_qty != $g['usage']){
                        //out dengan qty lama
                        $stock_card = new MStockCard;
                        $stock_card->setConnection(Auth::user()->db_name);
                        $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
                        $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
                        $stock_card->mstockcarddate = Carbon::parse($request->date);
                        $stock_card->mstockcardtranstype = $request->type;
                        $stock_card->mstockcardtransno = $trans_header->mhpurchaseno;
                        $stock_card->mstockcardremark = "Revisi Transaksi ".$request->type;
                        $stock_card->mstockcardstockin = 0;
                        $stock_card->mstockcardstockout = $old_qty;
                        $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
                        $stock_card->mstockcardwhouse = $g['warehouse'];
                        $stock_card->mstockcarduserid = Auth::user()->id;
                        $stock_card->mstockcardusername = Auth::user()->name;
                        $stock_card->mstockcardeventdate = Carbon::now();
                        $stock_card->mstockcardeventtime = Carbon::now();
                        $stock_card->edited = 1;
                        $stock_card->void = 0;
                        // $stock_card->mstockcardunit3 = $mgoods->mgoodscurrentunit3;
                        // $stock_card->mstockcardunit3conv = $mgoods->mgoodscurrentunit3conv;
                        // $stock_card->mstockcardunit3label = $mgoods->mgoodscurrentunit3label;
                        // $stock_card->mstockcardunit2 = $mgoods->mgoodscurrentunit2;
                        // $stock_card->mstockcardunit2conv = $mgoods->mgoodscurrentunit2conv;
                        // $stock_card->mstockcardunit2label = $mgoods->mgoodscurrentunit2label;
                        // $stock_card->mstockcardunit1 = $mgoods->mgoodscurrentunit1;
                        // $stock_card->mstockcardunit1conv = $mgoods->mgoodscurrentunit1conv;
                        // $stock_card->mstockcardunit1label = $mgoods->mgoodscurrentunit1label;
                        // out conversion
                        // $stock_card->mstockcardoutunit3 -= $last_stock->mstockcardinunit3;
                        // $stock_card->mstockcardoutunit3conv = $last_stock->mstockcardinunit3conv;
                        // $stock_card->mstockcardoutunit3label = $last_stock->mstockcardinunit3label;
                        // $stock_card->mstockcardoutunit2 -= $last_stock->mstockcardinunit2;
                        // $stock_card->mstockcardoutunit2conv = $last_stock->mstockcardinunit2conv;
                        // $stock_card->mstockcardoutunit2label = $last_stock->mstockcardinunit2label;
                        // $stock_card->mstockcardoutunit1 -= $last_stock->mstockcardinunit1;
                        // $stock_card->mstockcardoutunit1conv = $last_stock->mstockcardinunit1conv;
                        // $stock_card->mstockcardoutunit1label = $last_stock->mstockcardinunit1label;
                        $stock_card->save();

                        if($old_qty != $g['usage']){
                          $mgoods->mgoodsstock -= $last_stock->mstockcardstockin;
                        //   $mgoods->mgoodscurrentunit3 -= $last_stock->mstockcardinunit3;
                        //   $mgoods->mgoodscurrentunit3conv = $last_stock->mstockcardinunit3conv;
                        //   $mgoods->mgoodscurrentunit3label = $last_stock->mstockcardinunit3label;
                        //   $mgoods->mgoodscurrentunit2 -= $last_stock->mstockcardinunit2;
                        //   $mgoods->mgoodscurrentunit2conv = $last_stock->mstockcardinunit2conv;
                        //   $mgoods->mgoodscurrentunit2label = $last_stock->mstockcardinunit2label;
                        //   $mgoods->mgoodscurrentunit1 -= $last_stock->mstockcardinunit1;
                        //   $mgoods->mgoodscurrentunit1conv = $last_stock->mstockcardinunit1conv;
                        //   $mgoods->mgoodscurrentunit1label = $last_stock->mstockcardinunit1label;
                        }
                        $mgoods->save();

                        // in dengan yg baru
                        $stock_card = new MStockCard;
                        $stock_card->setConnection(Auth::user()->db_name);
                        $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
                        $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
                        $stock_card->mstockcarddate = Carbon::parse($request->date);
                        $stock_card->mstockcardtranstype = $request->type;
                        $stock_card->mstockcardtransno = $trans_header->mhpurchaseno;
                        $stock_card->mstockcardremark = "Editing Transaksi ".$request->type;
                        $stock_card->mstockcardstockin = $g['usage'];
                        $stock_card->mstockcardstockout = 0;
                        $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
                        $stock_card->mstockcardwhouse = $g['warehouse'];
                        $stock_card->mstockcarduserid = Auth::user()->id;
                        $stock_card->mstockcardusername = Auth::user()->name;
                        $stock_card->mstockcardeventdate = Carbon::now();
                        $stock_card->mstockcardeventtime = Carbon::now();
                        $stock_card->edited = 1;
                        $stock_card->void = 0;
                        // $stock_card->mstockcardunit3 = $mgoods->mgoodscurrentunit3;
                        // $stock_card->mstockcardunit3conv = $mgoods->mgoodscurrentunit3conv;
                        // $stock_card->mstockcardunit3label = $mgoods->mgoodscurrentunit3label;
                        // $stock_card->mstockcardunit2 = $mgoods->mgoodscurrentunit2;
                        // $stock_card->mstockcardunit2conv = $mgoods->mgoodscurrentunit2conv;
                        // $stock_card->mstockcardunit2label = $mgoods->mgoodscurrentunit2label;
                        // $stock_card->mstockcardunit1 = $mgoods->mgoodscurrentunit1;
                        // $stock_card->mstockcardunit1conv = $mgoods->mgoodscurrentunit1conv;
                        // $stock_card->mstockcardunit1label = $mgoods->mgoodscurrentunit1label;
                        // in conversion
                        // $stock_card->mstockcardinunit3 = $g['detail_goods_unit3'];
                        // $stock_card->mstockcardinunit3conv = $g['detail_goods_unit3_conv'];
                        // $stock_card->mstockcardinunit3label = $g['detail_goods_unit3_label'];
                        // $stock_card->mstockcardinunit2 = $g['detail_goods_unit2'];
                        // $stock_card->mstockcardinunit2conv = $g['detail_goods_unit2_conv'];
                        // $stock_card->mstockcardinunit2label = $g['detail_goods_unit2_label'];
                        // $stock_card->mstockcardinunit1 = $g['detail_goods_unit1'];
                        // $stock_card->mstockcardinunit1conv = $g['detail_goods_unit1_conv'];
                        // $stock_card->mstockcardinunit1label = $g['detail_goods_unit1_label'];
                        $stock_card->save();

                        $mgoods->mgoodsstock += $g['usage'];
                        // $mgoods->mgoodscurrentunit3 += $g['detail_goods_unit3'];
                        // $mgoods->mgoodscurrentunit3conv = $g['detail_goods_unit3_conv'];
                        // $mgoods->mgoodscurrentunit3label = $g['detail_goods_unit3_label'];
                        // $mgoods->mgoodscurrentunit2 += $g['detail_goods_unit2'];
                        // $mgoods->mgoodscurrentunit2conv = $g['detail_goods_unit2_conv'];
                        // $mgoods->mgoodscurrentunit2label = $g['detail_goods_unit2_label'];
                        // $mgoods->mgoodscurrentunit1 += $g['detail_goods_unit1'];
                        // $mgoods->mgoodscurrentunit1conv = $g['detail_goods_unit1_conv'];
                        // $mgoods->mgoodscurrentunit1label = $g['detail_goods_unit1_label'];
                        $mgoods->save();

                        // update detail reference
                        $invoice_detail->stock_ref = $stock_card->id;
                        $invoice_detail->save();
                    }
                } else {
                    // new data
                    $mgoods = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$g['goods']['mgoodscode'])->first();

                    $mgoods->mgoodspricein = $g['buy_price'];
                    $mgoods->save();

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
                    $detail->save();

                    // update stock card
                    $stock_card = new MStockCard;
                    $stock_card->setConnection(Auth::user()->db_name);
                    $stock_card->mstockcardgoodsid = $g['goods']['mgoodscode'];
                    $stock_card->mstockcardgoodsname = $g['goods']['mgoodsname'];
                    $stock_card->mstockcarddate = Carbon::parse($request->date);
                    $stock_card->mstockcardtranstype = $request->type;
                    $stock_card->mstockcardtransno = $header->mhpurchaseno;
                    $stock_card->mstockcardremark = "Transaksi ".$request->type." untuk ";
                    $stock_card->mstockcardstockin = $g['usage'];
                    $stock_card->mstockcardstockout = 0;
                    $stock_card->mstockcardstocktotal = $mgoods->mgoodsstock;
                    $stock_card->mstockcardwhouse = $g['warehouse'];
                    $stock_card->mstockcarduserid = Auth::user()->id;
                    $stock_card->mstockcardusername = Auth::user()->name;
                    $stock_card->mstockcardeventdate = Carbon::now();
                    $stock_card->mstockcardeventtime = Carbon::now();
                    $stock_card->edited = 0;
                    $stock_card->mstockcardunit3 = $mgoods->mgoodscurrentunit3;
                    $stock_card->mstockcardunit3conv = $mgoods->mgoodscurrentunit3conv;
                    $stock_card->mstockcardunit3label = $mgoods->mgoodscurrentunit3label;
                    $stock_card->mstockcardunit2 = $mgoods->mgoodscurrentunit2;
                    $stock_card->mstockcardunit2conv = $mgoods->mgoodscurrentunit2conv;
                    $stock_card->mstockcardunit2label = $mgoods->mgoodscurrentunit2label;
                    $stock_card->mstockcardunit1 = $mgoods->mgoodscurrentunit1;
                    $stock_card->mstockcardunit1conv = $mgoods->mgoodscurrentunit1conv;
                    $stock_card->mstockcardunit1label = $mgoods->mgoodscurrentunit1label;
                    // in conversion
                    $stock_card->mstockcardinunit3 = $g['detail_goods_unit3'];
                    $stock_card->mstockcardinunit3conv = $g['detail_goods_unit3_conv'];
                    $stock_card->mstockcardinunit3label = $g['detail_goods_unit3_label'];
                    $stock_card->mstockcardinunit2 = $g['detail_goods_unit2'];
                    $stock_card->mstockcardinunit2conv = $g['detail_goods_unit2_conv'];
                    $stock_card->mstockcardinunit2label = $g['detail_goods_unit2_label'];
                    $stock_card->mstockcardinunit1 = $g['detail_goods_unit1'];
                    $stock_card->mstockcardinunit1conv = $g['detail_goods_unit1_conv'];
                    $stock_card->mstockcardinunit1label = $g['detail_goods_unit1_label'];
                    $stock_card->save();

                    // update goods
                    $last_stock = $mgoods->mgoodsstock;
                    $mgoods->mgoodsstock += $g['usage'];
                    $mgoods->mgoodscurrentunit3 += $g['detail_goods_unit3'];
                    $mgoods->mgoodscurrentunit3conv = $g['detail_goods_unit3_conv'];
                    $mgoods->mgoodscurrentunit3label = $g['detail_goods_unit3_label'];
                    $mgoods->mgoodscurrentunit2 += $g['detail_goods_unit2'];
                    $mgoods->mgoodscurrentunit2conv = $g['detail_goods_unit2_conv'];
                    $mgoods->mgoodscurrentunit2label = $g['detail_goods_unit2_label'];
                    $mgoods->mgoodscurrentunit1 += $g['detail_goods_unit1'];
                    $mgoods->mgoodscurrentunit1conv = $g['detail_goods_unit1_conv'];
                    $mgoods->mgoodscurrentunit1label = $g['detail_goods_unit1_label'];
                    $mgoods->save();

                    // update COGS
                    // find first cogs
                    $goods_cogs = MCOGS::on(Auth::user()->db_name)->where('mcogsgoodscode',$mgoods->mgoodscode)->first();
                    if($goods_cogs == null){
                        $cogs = new MCOGS;
                        $cogs->setConnection(Auth::user()->db_name);
                        $cogs->mcogsgoodscode = $mgoods->mgoodscode;
                        $cogs->mcogsgoodsname = $mgoods->mgoodsname;
                        $cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                        $cogs->mcogslastcogs = $header->mhpurchasegrandtotal / $mgoods->mgoodsstock;
                        $cogs->mcogsremarks = "";
                        $cogs->save();
                    } else {
                        // update cogs
                        $goods_cogs->mcogsgoodstotalqty = $mgoods->mgoodsstock;
                        $cogs_num = (($last_stock * $goods_cogs->mcogslastcogs) + $header->mhpurchasegrandtotal ) / $mgoods->mgoodsstock;
                        $goods_cogs->mcogslastcogs = $cogs_num;
                        $goods_cogs->mcogsremarks = "";
                        $goods_cogs->save();
                    }
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
                $stock_card->mstockcardremark = "Editing Transaksi Hapus item".$request->type;
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

            DB::connection(Auth::user()->db_name)->commit();
            return 'ok';
        } catch(\Exception $e){
            var_dump($e);
            DB::connection(Auth::user()->db_name)->rollBack();
            return 'err';
        }
    }

    public static function delete_transaction($id){
        DB::connection(Auth::user()->db_name)->beginTransaction();
        try{
            $header = MHPurchase::on(Auth::user()->db_name)->where('id',$id)->first();
            $header->void = 1;
            $header->save();

            $details = MDPurchase::on(Auth::user()->db_name)->where('mhpurchaseno',$header->mhpurchaseno)->get();

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

                // void APCard;
                $ap = MAPCard::on(Auth::user()->db_name)->where('mapcardtransno',$detail->mhpurchaseno)->first();
                $ap->void = 1;
                $ap->save();
                DB::connection(Auth::user()->db_name)->commit();
                return 'ok';
            }

        } catch(\Exception $e){
            DB::connection(Auth::user()->db_name)->rollBack();
            return 'err';
        }
    }
}
