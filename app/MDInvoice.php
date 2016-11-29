<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MDInvoice extends Model
{
  protected $table = 'mdinvoice';
  protected static function boot(){
    parent::boot();
    static::addGlobalScope('actives', function(Builder $builder) {
        $builder->orderBy('mdinvoicedate','desc');
    });
  }
}
