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
}
