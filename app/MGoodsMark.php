<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MGoodsMark extends Model
{
    protected $table = "mcategorygoodsmark";
    protected $fillable = ['category_name','information'];
}
