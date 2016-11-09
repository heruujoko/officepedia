<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Mwarehouse extends Model
{
	protected $table = 'mwarehouse';
	protected $fillable = ['mwarehousename','mwarehouseremark'];
	protected static function boot(){
		parent::boot();
		static::addGlobalScope('actives', function(Builder $builder) {
					$builder->where('void', '=', 0);
		});
	}

}
