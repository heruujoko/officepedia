<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MGOODS extends Model
{
    protected $table = 'mgoods';
    protected $fillable = ['mgoodscode','mgoodsbarcode','mgoodsname','mgoodsalias','mgoodsremark','mgoodsunit','mgoodsunit2','mgoodsunit3','mgoodsactive','mgoodspricein','mgoodspriceout','mgoodstype','mgoodsbrand','mgoodsgroup1','mgoodsgroup2','mgoodsgroup3','mgoodssuppliercode','mgoodssuppliername','mgoodsbranches','mgoodsuniquetransaction','mgoodspicture','mgoodscoapurchasing','mgoodscoapurchasingname','mgoodscoacogs','mgoodscoacogsname','mgoodscoaselling','mgoodscoasellingname','mgoodscoareturnofselling','mgoodscoareturnofsellingname','mgoodscogs'];

        protected $casts = [
        'mgoodsactive' => 'integer',
        'mgoodsbranches' => 'integer',
        'mgoodsuniquetransaction' => 'integer',
        ];

}
