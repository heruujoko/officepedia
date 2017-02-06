<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\MBRANCH;
use Auth;

class Mwarehouse extends Model
{
	protected $table = 'mwarehouse';
	protected $fillable = ['mwarehousename','mwarehouseremark','mwarehousebranchid'];
	protected static function boot(){
		parent::boot();
		static::addGlobalScope('actives', function(Builder $builder) {
					$builder->where('void', '=', 0);
		});
	}

    public function cabang(){
        $branch = MBRANCH::on(Auth::user()->db_name)->where('mbranchcode',$this->mwarehousebranchid)->first();
        return $branch;
    }

}
