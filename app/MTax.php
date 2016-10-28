<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MTax extends Model
{
    protected $table = 'mtax';

    protected $fillable = ['mtaxtype','mtaxtdesc','mtaxtpercentage'];
}
