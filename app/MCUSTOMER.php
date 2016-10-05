<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MCUSTOMER extends Model
{
    protected $table = 'mcustomer';
    protected $fillable = ['mcustomerid','mcustomername','mcustomeremail','mcustomerphone','mcustomerfax','mcustomerwebsite','mcustomeraddress','mcustomercity','mcustomerzipcode','mcustomerprovince','mcustomercountry','mcustomercontactname','mcustomercontactposition','mcustomercontactemail','mcustomercontactemailphone','mcustomerarlimit','mcustomercoa','mcustomertop','mcustomerarmax','mcustomerdefaultar'];

    public function akun(){
      return $this->belongsTo('App\MCOA','mcustomercoa','id');
    }
}
