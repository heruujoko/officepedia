<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MGoods;
use Auth;

class HPPHistory extends Model
{
    protected $table = 'hpphistory';

    public function goods(){
        return MGoods::on(Auth::user()->db_name)->where('mgoodscode',$this->hpphistorygoodsid)->first();
    }
}
