<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MCOAParent;

class MCOA extends \LaravelArdent\Ardent\Ardent
{
    protected $table = "mcoa";

    public function parent(){
      return MCOAParent::findCode($this->mcoaparentcode);
    }

    public function set_parent($code){
      $p = MCOAParent::findCode($code);
      $this->mcoaparentcode = $p->mcoaparentcode;
      $this->mcoaparentname = $p->mcoaparentname;
      $gp = $p->parent();
      $this->mcoagrandparentcode = $gp->mcoagrandparentcode;
      $this->mcoagrandparentname = $gp->mcoagrandparentname;
    }

    public function afterSave(){
      $this->parent()->validateValue();
    }

    public function afterUpdate(){
      $this->parent()->validateValue();
    }
}
