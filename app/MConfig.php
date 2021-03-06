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
                            'msysprefixcashreceipt','msysprefixcashout','msysprefixbankrecon','msysstreet','msyscity','msyszipcode','msysprovince','msyscountry','msysnumseparator','msysnumseparatorset'
                          ];

    protected $casts = [
        'msyscomptaxable' => 'integer',
        'msysgenmanufacturingacc' => 'integer',
        'msysgenmultibranch' => 'integer',
        'msysgenmulticurrency' => 'integer',
        'msysgendefaulttax' => 'integer',
        'msysgenapproval' => 'integer',
        'msysgenfixedasset' => 'integer',
        'msysgenfixedasset' => 'integer',
        'msysinvquotation' => 'integer',
        'msysinvproformainvoice' => 'integer',
        'msysinvsellinginvoice' => 'integer',
        'msysinvlocksellingprice' => 'integer',
        'msysinvcreditlimit' => 'integer',
        'msysinvspbelowcog' => 'integer',
        'msysinvprintinvmorethanonce' => 'integer',
        'msysinvprintdomorethanonce' => 'integer',
        'msysinvprintordmorethanonce' => 'integer',
        'msysinvlptdirectprinting' => 'integer',
        'msyspurchrequest' => 'integer',
        'msyspurchorder' => 'integer',
        'msyspurchinvoice' => 'integer',
        'msyspurchcreditlimit' => 'integer',
        'msysbankminus' => 'integer',
        'msysinventmultiwarehouse' => 'integer',
        'msysinventmultiwarehouse' => 'integer',
        'msysinventmultiuom' => 'integer',
        'msysinventuseserial' => 'integer',
        'msysinventallowminus' => 'integer',
        'msysinventslabprice' => 'integer',
    ];

    public function get_last_count_format($count){
      if($count < 10){
        return "00".$count;
      } else if($count < 100){
        return "0".$count;
      } else {
        return $count;
      }
    }

    public function get_last_count_format14($count){
        if($count < 10){
          return "00".$count;
        } else if($count < 100){
          return "0".$count;
        } else {
          return $count;
        }
    }
}
