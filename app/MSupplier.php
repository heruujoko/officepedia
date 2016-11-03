<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use App\MCOA;
use App\MCactegorysupplier;
use Auth;
use App\Helper\DBHelper;

class MSupplier extends Model
{
    protected $table = 'msupplier';
    protected $fillable = ['msupplierid','msuppliername','msupplieremail','msupplierphone','msupplierfax','msupplierwebsite','msupplieraddress','msuppliercity','msupplierzipcode','msupplierprovince','msuppliercountry','msuppliercontactname','msuppliercontactposition','msuppliercontactemail','msuppliercontactemailphone','msupplierarlimit','msuppliercoa','msuppliertop','msupplierarmax','msupplierdefaultar','msuppliercategory'];

    protected static function boot(){

      parent::boot();

      static::addGlobalScope('actives', function(Builder $builder) {
            $builder->where('void', '=', 0);
      });

      static::created(function($msupplier){
        $msupplier->update_prefix_status();
      });

    }

    public function akun(){
      // return $this->belongsTo('App\MCOA','msuppliercoa','id');
      return MCOA::on(Auth::user()->db_name)->where('id',$this->msuppliercoa)->first();
    }

    public function doublecheckid(){
      $check = MSupplier::on(Auth::user()->db_name)->where('msupplierid',$this->msupplierid)->where('void',0)->get();
      $cnt = count($check);
      if($cnt > 1){
        return false;
      } else {
        return true;
      }
    }

    public function revert_creation(){
      $conf = MConfig::find(1);
      $conf->msysprefixsuppliercount = $conf->msysprefixsuppliercount-1;
      $conf->msysprefixsupplierlastcount = $conf->get_last_count_format($conf->msysprefixsuppliercount);
      $conf->save();
      $this->delete();
    }

    public function update_prefix_status(){
      $conf = MConfig::find(1);
      $conf->msysprefixsuppliercount = $conf->msysprefixsuppliercount+1;
      $conf->msysprefixsupplierlastcount = $conf->get_last_count_format($conf->msysprefixsuppliercount);
      $conf->save();
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      $conf = MConfig::find(1);
      try{
        DBHelper::configureConnection(Auth::user()->db_alias);
        DB::connection(Auth::user()->db_name)->select(DB::raw('call autogen("msupplier","'.$conf->msysprefixsupplier.'",'.$conf->msysprefixsuppliercount.',"msupplierid",'.$this->id.')'));
      } catch(Exception $e){
        var_dump($e);
        return $e;
      }

    }

    public function doublecheck($in){
      $conf = MConfig::find(1);
      $current = "";
      $incr = $conf->msysprefixsuppliercount+$in;

      DB::select(DB::raw('call finduniquemsupplier('.$this->id.','.$incr.')'));
    }

    public function category(){
      // return $this->belongsTo('App\MCategorysupplier','msuppliercategory','id');
      return MCategorysupplier::on(Auth::user()->db_name)->where('id',$this->msuppliercategory)->first();
    }
}
