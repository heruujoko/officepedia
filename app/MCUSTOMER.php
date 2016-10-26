<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;
class MCUSTOMER extends Model
{
    protected $table = 'mcustomer';
    protected $fillable = ['mcustomerid','mcustomername','mcustomeremail','mcustomerphone','mcustomerfax','mcustomerwebsite','mcustomeraddress','mcustomercity','mcustomerzipcode','mcustomerprovince','mcustomercountry','mcustomercontactname','mcustomercontactposition','mcustomercontactemail','mcustomercontactemailphone','mcustomerarlimit','mcustomercoa','mcustomertop','mcustomerarmax','mcustomerdefaultar'];

    protected static function boot(){

      parent::boot();

      static::created(function($memployee){
        $memployee->update_prefix_status();
      });

    }
    
    public function akun(){
      return $this->belongsTo('App\MCOA','mcustomercoa','id');
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      $conf = MConfig::find(1);
      try{
        DB::select(DB::raw('call autogen("mcustomer","'.$conf->msysprefixcustomer.'",'.$conf->msysprefixcustomercount.',"mcustomerid",'.$this->id.')'));
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
      $conf = MConfig::find(1);
      $conf->msysprefixcustomercount = $conf->msysprefixcustomercount-1;
      $conf->save();
      $this->delete();
    }

    public function update_prefix_status(){
      $conf = MConfig::find(1);
      $conf->msysprefixcustomercount = $conf->msysprefixcustomercount+1;
      $conf->save();
    }

    public function doublecheck($in){
      $conf = MConfig::find(1);
      $current = "";
      $incr = $conf->msysprefixcustomercount+$in;

      DB::select(DB::raw('call finduniquecustomer('.$this->id.','.$incr.')'));
    }
}
