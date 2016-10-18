<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MEmployeeLevel extends Model
{
    protected $table = "memployeelevel";
    protected $fillable = ['level','information'];
}
