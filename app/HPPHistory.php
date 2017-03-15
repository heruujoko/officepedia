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

    public function prev(){
        return HPPHistory::on(Auth::user()->db_name)->where('id',($this->id -1))->first();
    }

    public function next(){
        return HPPHistory::on(Auth::user()->db_name)->where('id',($this->id +1))->first();
    }
}
