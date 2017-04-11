<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MDepartement extends Model
{
    protected $table = 'mdepartement';
    protected $fillable = ['departement_name','information'];

    protected static function boot(){
      parent::boot();
      static::addGlobalScope('actives', function(Builder $builder) {
            $builder->where('void', '=', 0);
      });
    }

}
