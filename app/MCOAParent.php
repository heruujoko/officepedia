<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MCOAGrandParent;

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
      return MCOAParent::where('mcoaparentcode',$code)->first();
    }

    public function parent(){
      return MCOAGrandParent::findCode($this->mcoagrandparentcode);
    }

    public function childs(){
      return MCOA::where("mcoaparentcode",$this->mcoaparentcode)->get();
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
