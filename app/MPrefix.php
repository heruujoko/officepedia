<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class MPrefix extends Model
{
    protected $table = 'mprefix';
    protected $fillable = ['mprefix','mprefixtransaction','mprefixremark','last_count'];
}
