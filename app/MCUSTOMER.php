<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Auth;
use App\Helper\DBHelper;
use App\MCOA;

class MCUSTOMER extends Model
{
    protected $table = 'mcustomer';
    protected $fillable = ['mcustomerid','mcustomername','mcustomeremail','mcustomerphone','mcustomerfax','mcustomerwebsite','mcustomeraddress','mcustomercity','mcustomerzipcode','mcustomerprovince','mcustomercountry','mcustomercontactname','mcustomercontactposition','mcustomercontactemail','mcustomercontactemailphone','mcustomerarlimit','mcustomercoa','mcustomertop','mcustomerarmax','mcustomerdefaultar','mcustomercategory'];

    protected static function boot(){

      parent::boot();

      static::addGlobalScope('actives', function(Builder $builder) {
            $builder->where('void', '=', 0);
      });

      static::created(function($memployee){
        $memployee->update_prefix_status();
      });

    }

    public function categories(){
      // return $this->belongsTo('App\MCategorycustomer','mcustomercategory','id');
      return MCategorycustomer::on(Auth::user()->db_name)->where('id',$this->mcustomercategory)->first();
    }

    public function akun(){
      // return $this->belongsTo('App\MCOA','mcustomercoa','id');
      return MCOA::on(Auth::user()->db_name)->where('id',$this->mcustomercoa)->first();
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      try{
        DBHelper::configureConnection(Auth::user()->db_alias);
        DB::connection(Auth::user()->db_name)->select(DB::raw('call autogen("mcustomer","'.$conf->msysprefixcustomer.'",'.$conf->msysprefixcustomercount.',"mcustomerid",'.$this->id.')'));
      } catch(Exception $e){
        return $e;
      }

    }

    public function doublecheckid(){
      $check = MCUSTOMER::where('mcustomerid',$this->mcustomerid)->where('void',0)->get();
      $cnt = count($check);
      if($cnt > 1){
        return false;
      } else {
        return true;
      }
    }

    public function revert_creation(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixcustomercount = $conf->msysprefixcustomercount-1;
      $conf->msysprefixcustomerlastcount = $conf->get_last_count_format($conf->msysprefixcustomercount);
      $conf->save();
      $this->delete();
    }

    public function update_prefix_status(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixcustomercount = $conf->msysprefixcustomercount+1;
      $conf->msysprefixcustomerlastcount = $conf->get_last_count_format($conf->msysprefixcustomercount);
      $conf->save();
    }

    public function doublecheck($in){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $current = "";
      $incr = $conf->msysprefixcustomercount+$in;

      DB::select(DB::raw('call finduniquecustomer('.$this->id.','.$incr.')'));
    }
}
