<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MBRANCH extends Model
{
    protected $table = 'mbranch';
    protected $fillable = ['mbranchcode','mbranchname','address','phone','city','person_in_charge','information','void'];

    protected static function boot(){
      parent::boot();
      static::addGlobalScope('actives', function(Builder $builder) {
            $builder->where('void', '=', 0);
      });
    }
    
}
