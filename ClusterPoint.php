<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ClusterPoint extends Point{
    private $belongDataPointArr = array();//((1,1), (2,2))
    
    public function addDataPoint($dataPoint){
        /*echo "addDataPoint\n";
        var_dump($dataPoint);*/
        array_push($this->belongDataPointArr, $dataPoint);
    }
    
    public function flushBelongDataPoints(){
        $this->belongDataPointArr = array();
    }
    
    public function getBelongDataPoints(){
        return $this->belongDataPointArr;
    }
    
    public function __toString(){
        echo "ClusterPoint\n";
        echo "座標\n";
        var_dump($this->coordinates);
        echo "所属データポイント\n";
        var_dump($this->belongDataPointArr);
    }
}
