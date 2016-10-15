<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MSupplier extends Model
{
    protected $table = 'msupplier';
    protected $fillable = ['msupplierid','msuppliername','msupplieremail','msupplierphone','msupplierfax','msupplierwebsite','msupplieraddress','msuppliercity','msupplierzipcode','msupplierprovince','msuppliercountry','msuppliercontactname','msuppliercontactposition','msuppliercontactemail','msuppliercontactemailphone','msupplierarlimit','msuppliercoa','msuppliertop','msupplierarmax','msupplierdefaultar'];

    public function akun(){
      return $this->belongsTo('App\MCOA','msuppliercoa','id');
    }
}
