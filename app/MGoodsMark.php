<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MGoodsMark extends Model
{
    protected $table = "mcategorygoodsmark";
    protected $fillable = ['category_name','information'];

    protected static function boot(){
      parent::boot();
      static::addGlobalScope('actives', function(Builder $builder) {
            $builder->where('void', '=', 0);
      });
    }
}
