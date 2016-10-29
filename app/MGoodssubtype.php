<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MGoodssubtype extends Model
{
    protected $table = 'mgoodssubtype';
    protected $fillable = ['mgoodssubtypename','mgoodssubtypeparent','mgoodssubtyperemark'];
}
