<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;

class MGOODS extends Model
{
    protected $table = 'mgoods';
    protected $fillable = ['mgoodscode','mgoodsbarcode','mgoodsname','mgoodsalias','mgoodsremark','mgoodsunit','mgoodsunit2','mgoodsunit3','mgoodsactive','mgoodspricein','mgoodspriceout','mgoodstype','mgoodsbrand','mgoodsgroup1','mgoodsgroup2','mgoodsgroup3','mgoodssuppliercode','mgoodssuppliername','mgoodsbranches','mgoodsuniquetransaction','mgoodspicture','mgoodscoapurchasingname','mgoodscoapurchasingname','mgoodscoacogs','mgoodscoacogsname','mgoodscoaselling','mgoodscoasellingname','mgoodscoareturnofselling','mgoodscoareturnofsellingname','mgoodscogs'];

        protected $casts = [
        'mgoodsactive' => 'integer',
        'mgoodsbranches' => 'integer',
        'mgoodsuniquetransaction' => 'integer',
        ];

    public function autogen(){
      DB::select(DB::raw('call autogenmgoods('.$this->id.')'));
    }

    public function autogenproc(){
      $success = false;
      $attempt = 0;
      try{
        DB::select(DB::raw('call autogenmgoods('.$this->id.')'));
      } catch(Exception $e){
        do{
          try{
            $attempt++;
            $this->doublecheck($attempt);
            $success = true;
          }catch(Exception $e){
            $success = false;
          }
        } while($success == false);
      }

    }

    public function doublecheck($in){
      $conf = MConfig::find(1);
      $current = "";
      $incr = $conf->msysprefixgoodscount+$in;

      DB::select(DB::raw('call finduniquemgoods('.$this->id.','.$incr.')'));
    }

}
