<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MUnit extends Model
{
    protected $table = 'munits';
    protected $fillable = ['mgoodsunitname','mgoodsunitremark'];
}
