<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MConfig;
use DB;
use Exception;

class MEmployee extends Model
{
    protected $table = "memployee";
    protected $fillable = ['memployeeid','memployeetitle','memployeename','memployeeposition','memployeelevel','memployeephone','memployeehomephone','memployeebbmpin','memployeeidcard','memployeecity','memployeezipcode','memployeeprovince','memployeecountry','memployeeinfo'];

<<<<<<< HEAD
=======
    protected static function boot(){

      parent::boot();

      static::created(function($memployee){
        $memployee->update_prefix_status();
      });

    }

>>>>>>> f7c713e376d2d81ea3f4ad1dbc57f77e37428c38
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
      $success = false;
      $attempt = 0;
<<<<<<< HEAD
      try{
        DB::select(DB::raw('call autogenmemployee('.$this->id.')'));
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
      $conf = MConfig::find(1);
      try{
        // DB::select(DB::raw('call autogenmemployee('.$this->id.')'));
        DB::select(DB::raw('call autogen("memployee","'.$conf->msysprefixemployee.'",'.$conf->msysprefixemployeecount.',"memployeeid",'.$this->id.')'));
      } catch(Exception $e){
        return $e;
        // do{
        //   try{
        //     $attempt++;
        //     $this->doublecheck($attempt);
        //     $success = true;
        //   }catch(Exception $e){
        //     $success = false;
        //   }
        // } while($success == false);
>>>>>>> f7c713e376d2d81ea3f4ad1dbc57f77e37428c38
      }

    }

<<<<<<< HEAD
=======
    public function doublecheckid(){
      $check = MEmployee::where('memployeeid',$this->memployeeid)->where('void',0)->get();
      $cnt = count($check);
      if($cnt > 1){
        return false;
      } else {
        return true;
      }
    }

    public function revert_creation(){
      $conf = MConfig::find(1);
      $conf->msysprefixemployeecount = $conf->msysprefixemployeecount-1;
      $conf->save();
      $this->delete();
    }

    public function update_prefix_status(){
      $conf = MConfig::find(1);
      $conf->msysprefixemployeecount = $conf->msysprefixemployeecount+1;
      $conf->save();
    }

>>>>>>> f7c713e376d2d81ea3f4ad1dbc57f77e37428c38
    public function doublecheck($in){
      $conf = MConfig::find(1);
      $current = "";
      $incr = $conf->msysprefixemployeecount+$in;

      DB::select(DB::raw('call finduniquememployee('.$this->id.','.$incr.')'));
    }

    public function akun(){
      return $this->belongsTo('App\MCOA','memployeecoa','mcoacode');
    }

    public function level(){
      return $this->belongsTo('App\MEmployeeLevel','memployeelevel','id');
    }
}
