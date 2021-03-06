<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Auth;
use App\MGoodstype;
use App\MGoodssubtype;
use App\MGoodsMark;
use App\Supplier;
use App\Helper\DBHelper;
class MGOODS extends Model
{
    protected $table = 'mgoods';

    protected $fillable = ['mgoodscode','mgoodsbarcode','mgoodsname','mgoodsalias','mgoodsremark','mgoodsunit','mgoodsunit2','mgoodsunit3','mgoodsactive','mgoodspricein','mgoodspriceout','mgoodstype','mgoodsbrand','mgoodsgroup1','mgoodsgroup2','mgoodsgroup3','mgoodssuppliercode','mgoodssuppliername','mgoodsbranches','mgoodsuniquetransaction','mgoodspicture','mgoodscoapurchasing','mgoodscoapurchasingname',
    'mgoodscoacogs','mgoodscoacogsname','mgoodscoaselling','mgoodscoasellingname','mgoodscoareturnofselling','mgoodscoareturnofsellingname','mgoodscogs','mgoodssubtype','mgoodsmultiunit','mgoodsunit2conv','mgoodsunit3conv','mgoodsunitin','mgoodsminimumin','mgoodstaxppn','mgoodstaxppnbm','mgoodssetmaxdisc','mgoodsmaxdisc','mgoodstaxable'];
        protected $casts = [
        'mgoodsactive' => 'integer',
        'mgoodscategory' => 'integer',
        'mgoodsbranches' => 'integer',
        'mgoodsuniquetransaction' => 'integer',
        'mgoodsmultiunit' => 'integer',
        'mgoodssetmaxdisc' => 'integer',
        'mgoodstaxable' => 'integer',
        ];

    protected static function boot(){

      parent::boot();

      static::addGlobalScope('actives', function(Builder $builder) {
  					$builder->where('void', '=', 0);
  		});

      static::created(function($mgoods){
        $mgoods->update_prefix_status();
      });

    }

    public function doublecheckid(){
      $check = MGoods::on(Auth::user()->db_name)->where('mgoodscode',$this->mgoodscode)->where('void',0)->get();
      $cnt = count($check);
      if($cnt > 1){
        return false;
      } else {
        return true;
      }
    }

    public function revert_creation(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixgoodscount = $conf->msysprefixgoodscount-1;
      $conf->msysprefixgoodslastcount = $conf->get_last_count_format14($conf->msysprefixgoodscount);
      $conf->save();
      $this->delete();
    }

    public function update_prefix_status(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixgoodscount = $conf->msysprefixgoodscount+1;
      $conf->msysprefixgoodslastcount = $conf->get_last_count_format14($conf->msysprefixgoodscount);
      $conf->save();
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      try{
        DBHelper::configureConnection(Auth::user()->db_alias);
        DB::connection(Auth::user()->db_name)->select(DB::raw('call autogengoods("mgoods","'.$conf->msysprefixgoods.'",'.$conf->msysprefixgoodscount.',"mgoodscode",'.$this->id.')'));
      } catch(Exception $e){
        return $e;
      }

    }

    public function doublecheck($in){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $current = "";
      $incr = $conf->msysprefixgoodscount+$in;

      DB::select(DB::raw('call finduniquemgoods('.$this->id.','.$incr.')'));
    }

    public function category(){
      // return $this->belongsTo('App\MCategorygoods','mgoodscategory','id');
      return MCategorygoods::on(Auth::user()->db_name)->where('id',$this->mgoodscategory)->first();
    }

    public function types(){
      // return $this->belongsTo('App\MGoodstype','mgoodstype','id');
      return MGoodstype::on(Auth::user()->db_name)->where('id',$this->mgoodstype)->first();
    }

    public function subtypes(){
      // return $this->belongsTo('App\MGoodssubtype','mgoodssubtype','id');
      return MGoodssubtype::on(Auth::user()->db_name)->where('id',$this->mgoodssubtype)->first();
    }

    public function mark(){
      // return $this->belongsTo('App\MGoodsMark','mgoodsbrand','id');
      return MGoodsMark::on(Auth::user()->db_name)->where('id',$this->mgoodsbrand)->first();
    }

    public function supplier(){
      // return $this->belongsTo('App\MSupplier','mgoodssuppliercode','msupplierid');
      return MSupplier::on(Auth::user()->db_name)->where('msupplierid',$this->mgoodssuppliercode)->first();
    }

}
