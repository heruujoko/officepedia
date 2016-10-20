<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MConfig;
use DB;

class MEmployee extends Model
{
    protected $table = "memployee";
    protected $fillable = ['memployeeid','memployeetitle','memployeename','memployeeposition','memployeelevel','memployeephone','memployeehomephone','memployeebbmpin','memployeeidcard','memployeecity','memployeezipcode','memployeeprovince','memployeecountry','memployeecontactname','memployeecontactposition','memployeecontactemail','memployeecontactemailphone','memployeearlimit','memployeecoa','memployeetop','memployeearmax','memployeedefaultar'];

    public function autogenid(){
      $conf = MConfig::find(1);
      $prefix = $conf->msysprefixemployee;
      $count = $conf->msysprefixemployeecount;
      $count++;
      $last_count = $conf->get_last_count_format($count);
      $this->memployeeid = $prefix.$last_count;
      $this->save();
      $conf->msysprefixemployeecount = $count;
      $conf->msysprefixemployeelastcount = $conf->get_last_count_format($count);
      $conf->save();
    }

    public function autogenproc(){
      DB::select(DB::raw('call autogenmemployee('.$this->id.')'));
    }

    public function akun(){
      return $this->belongsTo('App\MCOA','memployeecoa','mcoacode');
    }
}
