<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MARCard extends Model
{
    protected $table = 'marcard';

    protected static function boot(){
  		parent::boot();
  		static::addGlobalScope('actives', function(Builder $builder) {
  					$builder->where('void', '=', 0);
  		});
  	}
}
