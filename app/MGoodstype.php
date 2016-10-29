<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MGoodstype extends Model
{
    protected $table = 'mgoodstype';
    protected $fillable = ['mgoodstypename','mgoodstyperemark'];
}
