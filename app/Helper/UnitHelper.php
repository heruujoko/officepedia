<?php

namespace App\Helper;

class UnitHelper {

    public static function singlelabel($mgoods,$qty){
        $label1 = $mgoods->mgoodsunit;

        $label_str = "";
        if($qty == 0){
            $label_str = "-";
        } else {
            return $qty." ".$label1;
        }
    }

    public static function label($mgoods,$qty){
        $conv3 = $mgoods->mgoodsunit3conv;
        $conv2 = $mgoods->mgoodsunit2conv;

        $label3 = $mgoods->mgoodsunit3;
        $label2 = $mgoods->mgoodsunit2;
        $label1 = $mgoods->mgoodsunit;

        $label_str = "";
        if($qty == 0){
            $label_str = "-";
        }

        if($qty >= $conv3 && $conv3 != 0){
            $label_str .= "".floor($qty / $conv3)." ".$label3." ";
            $qty = $qty % $conv3;
        }
        if($qty >= $conv2 && $conv2 != 0){
            $label_str .= floor($qty / $conv2)." ".$label2." ";
            $qty = $qty % $conv2;
        }

        if($qty >= 1){
            $label_str .= " ".$qty." Unit";
        }

        return $label_str;
    }

}
