<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MGoodstype extends Model
{
    protected $table = 'mgoodstype';
    protected $fillable = ['mgoodstypename','mgoodstyperemark'];

    protected static function boot(){
      parent::boot();
      static::addGlobalScope('actives', function(Builder $builder) {
            $builder->where('void', '=', 0);
      });
    }
}
