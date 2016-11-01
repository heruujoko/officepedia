<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MGoodsbrand extends Model
{
	protected $table = 'mgoodsbrand';
	protected $fillable = ['mgoodsbrandname','mgoodsbrandremark'];

	protected static function boot(){
		parent::boot();
		static::addGlobalScope('actives', function(Builder $builder) {
					$builder->where('void', '=', 0);
		});
	}

}
