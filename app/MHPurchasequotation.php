<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MConfig;
use Carbon\Carbon;
use Auth;
use DB;
use App\MGoods;
use App\MDPurchasequotation;
use App\Helper\DBHelper;
use App\MStockCard;
use App\MAPCard;
use App\MCOGS;
use App\HPPHistory;

class MHPurchasequotation extends Model
{
    protected $table = 'mhpurchasequotation';
    protected $fillable = ['mhpurchasequotationno','mhpurchasequotationdeliveryno','mhpurchasequotationorderyno','mhpurchasequotationsupplierid','mhpurchasequotationsuppliername','mhpurchasequotationdate','mhpurchasequotationduedate','mhpurchasequotationsubtotal','mhpurchasequotationtaxtotal','mhpurchasequotationdiscounttotal','mhpurchasequotationwithppn','mhpurchasequotationremark'];
    protected static function boot(){
  		parent::boot();
  		static::addGlobalScope('actives', function(Builder $builder) {
  				$builder->where('void', '=', 0);
                $builder->orderBy('mhpurchasequotationdate','desc');
  		});
      static::created(function($mhpurchasequotation){
        $mhpurchasequotation->update_prefix_status();
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
        DB::connection(Auth::user()->db_name)->select(DB::raw('call autogen("mhpurchasequotation","'.$conf->msysprefixpurchinv.'",'.$conf->msysprefixpurchinvcount.',"mhpurchasequotationno",'.$this->id.')'));
      } catch(Exception $e){
        var_dump($e);
        return $e;
      }
    }

    
   
}
