<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Helper\DBHelper;

class MCOAGrandParent extends \LaravelArdent\Ardent\Ardent
{
    protected $table = "mcoagrandparent";
    protected $fillable = ['mcoagrandparentcode','mcoagrandparentname','mcoagrandparenttype'];

    public static function boot(){
        DBHelper::configureConnection(Auth::user()->db_alias);
        static::on(Auth::user()->db_name);
        static::addGlobalScope(function(\LaravelArdent\Ardent\Builder $builder){
          $builder->where('void',0);
        });
        parent::boot();
    }

    public static function findCode($code){
      return MCOAGrandParent::where('mcoagrandparentcode',$code)->first();
    }

    public function childs(){
      return MCOAParent::on(Auth::user()->db_name)->where("mcoagrandparentcode",$this->mcoagrandparentcode)->get();
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
    }
}
