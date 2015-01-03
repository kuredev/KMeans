<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Distance {
    protected function innerProduct($arr1, $arr2){
        for($i = 0; $i < sizeof($arr1); $i++){
            $result =+ $arr1[$i] * $arr2[$i];
        }
        return $result;
    }
}



