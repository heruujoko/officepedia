<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MConfig extends Model
{
    protected $table = 'mconfig';
    protected $fillable = ['msyscompname','msyscompphone','msyscompfax','msyscompemail','msyscompwebsite','msyscompcurrency','msyscompaddress','msyscomplogo',
                            'msyscomptaxpayeridnumber','msyscomptaxable','msyscomptaxablenumber','msyscompklu','msyscomptaxpayeridaddress',
                            'msysgenmanufacturingacc','msysgenmultibranch','msysgenmulticurrency','msysgendefaulttax','msysgenapproval','msysgenfixedasset','msysgenrounddec',
                            'msysprefixgoods','msysprefixsupplier','msysprefixcustomer','msysprefixemployee',
                            'msysprefixinvquotation','msysprefixinvorder','msysprefixinvoice',
                            'msysprefixpurchrequest','msysprefixpurchorder','msysprefixpurchinv','msysprefixedasset',
                            'msysprefixcashreceipt','msysprefixcashout','msysprefixbankrecon'
                          ];

    // protected $casts = [
    //     'msyscomptaxable' => 'boolean',
    //     'msysgenmanufacturingacc' => 'boolean'
    // ];
}
