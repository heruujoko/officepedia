<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MGoods;
use Auth;
use App\MBRANCH;

class HPPHistory extends Model
{
    protected $table = 'hpphistory';

    public function goods(){
        return MGoods::on(Auth::user()->db_name)->where('mgoodscode',$this->hpphistorygoodsid)->first();
    }

    public function prev(){
        $same = true;
        $count = 0;
        $prev_trans = [];
        $branch = MBRANCH::on(Auth::user()->db_name)->where('id',Auth::user()->defaultbranch)->first();
        while($same){
            $count++;
            $hist = HPPHistory::on(Auth::user()->db_name)->where('id',($this->id -$count))->first();
            if(($hist->transno != $this->transno) && ($hist->void == 0) && ($hist->branchid == $branch->mbranchcode)){
                $same = false;
                $prev_trans = $hist;
            }
        }
        return $prev_trans;
    }

    public function next(){
        return HPPHistory::on(Auth::user()->db_name)->where('id',($this->id +1))->first();
    }
}
