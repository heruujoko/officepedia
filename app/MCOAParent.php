<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MCOAGrandParent;
use App\Helper\DBHelper;
use Auth;
class MCOAParent extends \LaravelArdent\Ardent\Ardent
{
    protected $table = "mcoaparent";

    public static function boot(){
        static::addGlobalScope(function(\LaravelArdent\Ardent\Builder $builder){
          $builder->where('void',0);
        });
        parent::boot();
    }

    public static function findCode($code){
      return MCOAParent::on(Auth::user()->db_name)->where('mcoaparentcode',$code)->first();
    }

    public function parent(){
      return MCOAGrandParent::on(Auth::user()->db_name)->where('mcoagrandparentcode',$this->mcoagrandparentcode)->first();
    }

    public function childs(){
      return MCOA::on(Auth::user()->db_name)->where("mcoaparentcode",$this->mcoaparentcode)->get();
    }

    public function afterCreate(){
      $this->void = false;
      $this->save();
    }

    public function validateValue(){
      $val = 0;
      foreach($this->childs() as $ch){
        $val += $ch->saldo;
      }
      $this->saldo = $val;
      $this->save();
      $this->parent()->validateValue();
    }
}
