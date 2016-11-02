<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MCOAParent;
use DB;
use App\Helper\DBHelper;
use Auth;

class MCOA extends \LaravelArdent\Ardent\Ardent
{
    protected $table = "mcoa";

    public static function boot(){
        static::addGlobalScope(function(\LaravelArdent\Ardent\Builder $builder){
          $builder->where('void',0);
        });
        parent::boot();
    }

    public function parent(){
      // return MCOAParent::findCode($this->mcoaparentcode);
      return MCOAParent::on(Auth::user()->db_name)->where('mcoaparentcode',$this->mcoaparentcode)->first();
    }

    public function set_parent($code){
      $p = MCOAParent::on(Auth::user()->db_name)->where('mcoaparentcode',$code)->first();
      $this->mcoaparentcode = $p->mcoaparentcode;
      $this->mcoaparentname = $p->mcoaparentname;
      $gp = $p->parent();
      $this->mcoagrandparentcode = $gp->mcoagrandparentcode;
      $this->mcoagrandparentname = $gp->mcoagrandparentname;
    }

    public function afterSave(){
      // $this->parent()->validateValue();
    }

    public function afterCreate(){
      $this->void = false;
      $this->save();
    }

    public function afterUpdate(){
      // $this->parent()->validateValue();
    }

    public function auto_code(){
      $childs = DB::table('mcoa')->where('mcoaparentcode',$this->mcoaparentcode)->get();
      $count = count($childs);
      $count++;
      $string_count = "";
      if($count < 10){
        $string_count = "0".$count;
      } else {
        $string_count = "".$count;
      }
      $parent_code = $this->parent()->mcoaparentcode;
      $p = explode(".",$parent_code);
      return $p[0].".".$string_count;
    }
}
