<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MTax extends Model
{
    protected $table = 'mtax';

    protected $fillable = ['mtaxtype','mtaxtdesc','mtaxtpercentage'];

    protected static function boot(){
      parent::boot();
      static::addGlobalScope('actives', function(Builder $builder) {
            $builder->where('mtaxtype', '!=', 'Kosong')
            ->where('void', '=', 0);
      });
    }
}
