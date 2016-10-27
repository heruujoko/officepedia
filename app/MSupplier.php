<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;

class MSupplier extends Model
{
    protected $table = 'msupplier';
    protected $fillable = ['msupplierid','msuppliername','msupplieremail','msupplierphone','msupplierfax','msupplierwebsite','msupplieraddress','msuppliercity','msupplierzipcode','msupplierprovince','msuppliercountry','msuppliercontactname','msuppliercontactposition','msuppliercontactemail','msuppliercontactemailphone','msupplierarlimit','msuppliercoa','msuppliertop','msupplierarmax','msupplierdefaultar','msuppliercategory'];

<<<<<<< HEAD
=======
    protected static function boot(){

      parent::boot();

      static::created(function($msupplier){
        $msupplier->update_prefix_status();
      });

    }

>>>>>>> f7c713e376d2d81ea3f4ad1dbc57f77e37428c38
    public function akun(){
      return $this->belongsTo('App\MCOA','msuppliercoa','id');
    }

<<<<<<< HEAD
    public function autogenproc(){
      $success = false;
      $attempt = 0;
      try{
        DB::select(DB::raw('call autogenmsupplier('.$this->id.')'));
      } catch(Exception $e){
        do{
          try{
            $attempt++;
            $this->doublecheck($attempt);
            $success = true;
          }catch(Exception $e){
            $success = false;
          }
        } while($success == false);
=======
    public function doublecheckid(){
      $check = MSupplier::where('msupplierid',$this->msupplierid)->where('void',0)->get();
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
      $conf->save();
      $this->delete();
    }

    public function update_prefix_status(){
      $conf = MConfig::find(1);
      $conf->msysprefixsuppliercount = $conf->msysprefixsuppliercount+1;
      $conf->save();
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      $conf = MConfig::find(1);
      try{
        DB::select(DB::raw('call autogen("msupplier","'.$conf->msysprefixsupplier.'",'.$conf->msysprefixsuppliercount.',"msupplierid",'.$this->id.')'));
      } catch(Exception $e){
        return $e;
>>>>>>> f7c713e376d2d81ea3f4ad1dbc57f77e37428c38
      }

    }

    public function doublecheck($in){
      $conf = MConfig::find(1);
      $current = "";
      $incr = $conf->msysprefixsuppliercount+$in;

      DB::select(DB::raw('call finduniquemsupplier('.$this->id.','.$incr.')'));
    }

    public function category(){
      return $this->belongsTo('App\MCategorysupplier','msuppliercategory','id');
    }
}
