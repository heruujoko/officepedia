<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MCOAGrandParent extends Model
{
    protected $table = "mcoagrandparent";
    protected $fillable = ['mcoagrandparentcode','mcoagrandparentname','mcoagrandparenttype'];

    public static function findCode($code){
      return MCOAGrandParent::where('mcoagrandparentcode',$code)->first();
    }

    public function childs(){
      return MCOAParent::where("mcoagrandparentcode",$this->mcoagrandparentcode)->get();
    }

    public function validateValue(){
      $val = 0;
      foreach($this->childs() as $ch){
        $val += $ch->saldo;
      }
      $this->saldo = $val;
      $this->save();
    }
}
