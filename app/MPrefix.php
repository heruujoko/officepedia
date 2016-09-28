<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class MPrefix extends \LaravelArdent\Ardent\Ardent
{
    protected $table = 'mprefix';
    protected $fillable = ['mprefix','mprefixtransaction','mprefixremark','last_count'];

    public static function boot(){
        static::addGlobalScope(function(\LaravelArdent\Ardent\Builder $builder){
          $builder->where('void',0);
        });
        parent::boot();
    }

    public function afterCreate(){
      $this->void = false;
      $this->save();
    }
}
