<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;

class MSupplier extends Model
{
    protected $table = 'msupplier';
    protected $fillable = ['msupplierid','msuppliername','msupplieremail','msupplierphone','msupplierfax','msupplierwebsite','msupplieraddress','msuppliercity','msupplierzipcode','msupplierprovince','msuppliercountry','msuppliercontactname','msuppliercontactposition','msuppliercontactemail','msuppliercontactemailphone','msupplierarlimit','msuppliercoa','msuppliertop','msupplierarmax','msupplierdefaultar','msuppliercategory'];

    public function akun(){
      return $this->belongsTo('App\MCOA','msuppliercoa','id');
    }

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
