<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MEmployeeLevel extends \LaravelArdent\Ardent\Ardent
{

    public static function boot(){
        static::addGlobalScope(function(\LaravelArdent\Ardent\Builder $builder){
          $builder->where('void',0);
        });
        parent::boot();
    }

    protected $table = "memployeelevel";
    protected $fillable = ['level','information'];
}
