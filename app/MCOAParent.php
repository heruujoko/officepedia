<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MCOAGrandParent;

class MCOAParent extends Model
{
    protected $table = "mcoaparent";

    public static function findCode($code){
      return MCOAParent::where('mcoaparentcode',$code)->first();
    }

    public function parent(){
      return MCOAGrandParent::findCode($this->mcoagrandparentcode);
    }

    public function childs(){
      return MCOA::where("mcoaparentcode",$this->mcoaparentcode)->get();
    }
}
