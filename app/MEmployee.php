<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MConfig;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Auth;
use App\MCOA;
use App\MEmployeeLevel;

class MEmployee extends Model
{
    protected $table = "memployee";
    protected $fillable = ['memployeeid','memployeetitle','memployeename','memployeeposition','memployeelevel','memployeephone','memployeehomephone','memployeebbmpin','memployeeidcard','memployeecity','memployeezipcode','memployeeprovince','memployeecountry','memployeeinfo'];

    protected static function boot(){

      parent::boot();

      static::addGlobalScope('actives', function(Builder $builder) {
            $builder->where('void', '=', 0);
      });

      static::created(function($memployee){
        $memployee->update_prefix_status();
      });

    }
    public function autogenid(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
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
      $success = false;
      $attempt = 0;
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      try{
        // DB::select(DB::raw('call autogenmemployee('.$this->id.')'));
        DB::connection(Auth::user()->db_name)->select(DB::raw('call autogen("memployee","'.$conf->msysprefixemployee.'",'.$conf->msysprefixemployeecount.',"memployeeid",'.$this->id.')'));
      } catch(Exception $e){
        return $e;
      }

    }

    public function doublecheckid(){
      $check = MEmployee::on(Auth::user()->db_name)->where('memployeeid',$this->memployeeid)->where('void',0)->get();
      $cnt = count($check);
      if($cnt > 1){
        return false;
      } else {
        return true;
      }
    }

    public function revert_creation(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixemployeecount = $conf->msysprefixemployeecount-1;
      $conf->msysprefixemployeelastcount = $conf->get_last_count_format($conf->msysprefixemployeecount);
      $conf->save();
      $this->delete();
    }

    public function update_prefix_status(){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $conf->msysprefixemployeecount = $conf->msysprefixemployeecount+1;
      $conf->msysprefixemployeelastcount = $conf->get_last_count_format($conf->msysprefixemployeecount);
      $conf->save();
    }

    public function doublecheck($in){
      $conf = MConfig::on(Auth::user()->db_name)->where('id',1)->first();
      $current = "";
      $incr = $conf->msysprefixemployeecount+$in;

      DB::select(DB::raw('call finduniquememployee('.$this->id.','.$incr.')'));
    }

    public function akun(){
      // return $this->belongsTo('App\MCOA','memployeecoa','mcoacode');
      return MCOA::on(Auth::user()->db_name)->where('mcoacode',$this->memployeecoa)->first();
    }

    public function level(){
      // return $this->belongsTo('App\MEmployeeLevel','memployeelevel','id');
      return MEmployeeLevel::on(Auth::user()->db_name)->where('id',$this->memployeelevel)->first();
    }
}
