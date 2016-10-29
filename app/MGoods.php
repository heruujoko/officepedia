<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;

class MGOODS extends Model
{
    protected $table = 'mgoods';

<<<<<<< HEAD
    protected $fillable = ['mgoodscode','mgoodsbarcode','mgoodsname','mgoodsalias','mgoodsremark','mgoodsunit','mgoodsunit2','mgoodsunit3','mgoodsactive','mgoodspricein','mgoodspriceout','mgoodstype','mgoodsbrand','mgoodsgroup1','mgoodsgroup2','mgoodsgroup3','mgoodssuppliercode','mgoodssuppliername','mgoodsbranches','mgoodsuniquetransaction','mgoodspicture','mgoodscoapurchasing','mgoodscoapurchasingname','mgoodscoacogs','mgoodscoacogsname','mgoodscoaselling','mgoodscoasellingname','mgoodscoareturnofselling','mgoodscoareturnofsellingname','mgoodscogs'];
=======
    protected $fillable = ['mgoodscode','mgoodsbarcode','mgoodsname','mgoodsalias','mgoodsremark','mgoodsunit','mgoodsunit2','mgoodsunit3','mgoodsactive','mgoodspricein','mgoodspriceout','mgoodstype','mgoodsbrand','mgoodsgroup1','mgoodsgroup2','mgoodsgroup3','mgoodssuppliercode','mgoodssuppliername','mgoodsbranches','mgoodsuniquetransaction','mgoodspicture','mgoodscoapurchasing','mgoodscoapurchasingname',
    'mgoodscoacogs','mgoodscoacogsname','mgoodscoaselling','mgoodscoasellingname','mgoodscoareturnofselling','mgoodscoareturnofsellingname','mgoodscogs','mgoodssubtype','mgoodsmultiunit','mgoodsunit2conv','mgoodsunit3conv'];
>>>>>>> e46a5c3d7cc260a382fd38a62f2fc12940024e3e

        protected $casts = [
        'mgoodsactive' => 'integer',
        'mgoodsbranches' => 'integer',
        'mgoodsuniquetransaction' => 'integer',
        'mgoodsmultiunit' => 'integer',
        ];

    protected static function boot(){

      parent::boot();

      static::created(function($mgoods){
        $mgoods->update_prefix_status();
      });

    }

    public function doublecheckid(){
      $check = MGoods::where('mgoodscode',$this->mgoodscode)->where('void',0)->get();
      $cnt = count($check);
      if($cnt > 1){
        return false;
      } else {
        return true;
      }
    }

    public function revert_creation(){
      $conf = MConfig::find(1);
      $conf->msysprefixgoodscount = $conf->msysprefixgoodscount-1;
      $conf->msysprefixgoodslastcount = $conf->get_last_count_format14($conf->msysprefixgoodscount);
      $conf->save();
      $this->delete();
    }

    public function update_prefix_status(){
      $conf = MConfig::find(1);
      $conf->msysprefixgoodscount = $conf->msysprefixgoodscount+1;
      $conf->msysprefixgoodslastcount = $conf->get_last_count_format14($conf->msysprefixgoodscount);
      $conf->save();
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      $conf = MConfig::find(1);
      try{
        DB::select(DB::raw('call autogengoods("mgoods","'.$conf->msysprefixgoods.'",'.$conf->msysprefixgoodscount.',"mgoodscode",'.$this->id.')'));
      } catch(Exception $e){
        return $e;
      }

    }

    public function doublecheck($in){
      $conf = MConfig::find(1);
      $current = "";
      $incr = $conf->msysprefixgoodscount+$in;

      DB::select(DB::raw('call finduniquemgoods('.$this->id.','.$incr.')'));
    }

    public function category(){
      return $this->belongsTo('App\MCategorygoods','mgoodstype','id');
    }

    public function mark(){
      return $this->belongsTo('App\MGoodsMark','mgoodsbrand','id');
    }

    public function supplier(){
      return $this->belongsTo('App\MSupplier','mgoodssuppliercode','msupplierid');
    }

}
