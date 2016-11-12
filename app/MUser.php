<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MUser extends Model
{
    protected $table = 'muser';
    protected $fillable = ['musername','muserpass','musercategory'];

    protected static function boot(){
      parent::boot();
      static::addGlobalScope('actives', function(Builder $builder) {
            $builder->where('void', '=', 0);
      });
    }
}
