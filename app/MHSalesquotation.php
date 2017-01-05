<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MConfig;
use Carbon\Carbon;
use Auth;
use DB;
use App\MGoods;
use App\MDSalesquotation;
use App\Helper\DBHelper;
use App\MStockCard;
use App\MAPCard;
use App\MCOGS;
use App\HPPHistory;

class MHSalesquotation extends Model
{
    protected $table = 'mhsalesquotation';
    protected $fillable = ['mhsalesquotationno','mhsalesquotationdeliveryno','mhsalesquotationorderyno','mhsalesquotationsupplierid','mhsalesquotationsuppliername','mhsalesquotationdate','mhsalesquotationduedate','mhsalesquotationsubtotal','mhsalesquotationtaxtotal','mhsalesquotationdiscounttotal','mhsalesquotationwithppn','mhsalesquotationremark'];
    protected static function boot(){
  		parent::boot();
  		static::addGlobalScope('actives', function(Builder $builder) {
  				$builder->where('void', '=', 0);
                $builder->orderBy('mhsalesquotationdate','desc');
  		});
      static::created(function($mhsalesquotation){
        $mhsalesquotation->update_prefix_status();
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
        DB::connection(Auth::user()->db_name)->select(DB::raw('call autogen("mhsalesquotation","'.$conf->msysprefixpurchinv.'",'.$conf->msysprefixpurchinvcount.',"mhsalesquotationno",'.$this->id.')'));
      } catch(Exception $e){
        var_dump($e);
        return $e;
      }
    }

    
   
}
