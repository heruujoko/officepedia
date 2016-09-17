<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class MBRANCH extends Model
{
    protected $table = 'mbranch';
    protected $fillable = ['mbranchcode','mbranchname','address','phone','city','person_in_charge','information','void'];

    
}
