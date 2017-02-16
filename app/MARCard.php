<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;
use Carbon\Carbon;

class MARCard extends Model
{
    protected $table = 'marcard';

    protected static function boot(){
  		parent::boot();
  		static::addGlobalScope('actives', function(Builder $builder) {
  				$builder->where('void', '=', 0);
                $builder->orderBy('marcarddate', 'desc');
  		});
  	}

    public static function get_accumulate_history($invoice_no,$from_date){
        $pay_sum = 0;
        $ars = MARCard::on(Auth::user()->db_name)->where('marcardtransno',$invoice_no)->whereDate('marcarddate','>=',Carbon::parse($from_date))->orderBy('created_at','asc')->get();
        foreach ($ars as $ar) {
            $pay_sum += $ar->marcardpayamount;
        }

        $last_ar = $ars->last();
        $last_ar['pay_sum'] = $pay_sum;
        return $last_ar;
    }
}
