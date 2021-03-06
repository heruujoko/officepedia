<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MGoodssubtype extends Model
{
    protected $table = 'mgoodssubtype';
    protected $fillable = ['mgoodssubtypename','mgoodssubtypeparent','mgoodssubtyperemark'];

    protected static function boot(){
      parent::boot();
      static::addGlobalScope('actives', function(Builder $builder) {
            $builder->where('void', '=', 0);
      });
    }
}
