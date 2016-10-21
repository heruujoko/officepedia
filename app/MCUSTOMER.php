<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;
class MCUSTOMER extends Model
{
    protected $table = 'mcustomer';
    protected $fillable = ['mcustomerid','mcustomername','mcustomeremail','mcustomerphone','mcustomerfax','mcustomerwebsite','mcustomeraddress','mcustomercity','mcustomerzipcode','mcustomerprovince','mcustomercountry','mcustomercontactname','mcustomercontactposition','mcustomercontactemail','mcustomercontactemailphone','mcustomerarlimit','mcustomercoa','mcustomertop','mcustomerarmax','mcustomerdefaultar'];

    public function akun(){
      return $this->belongsTo('App\MCOA','mcustomercoa','id');
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      try{
        DB::select(DB::raw('call autogenmcustomer('.$this->id.')'));
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
      $incr = $conf->msysprefixcustomercount+$in;

      DB::select(DB::raw('call finduniquecustomer('.$this->id.','.$incr.')'));
    }
}
