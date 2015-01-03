<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class EuclidDistance extends Distance implements DistanceInerface{
    
    /**
     * ユークリッド距離を求める関数
     * @param type $data1
     * @param type $data2
     */
    public function distance($data1, $data2) {
        $num = 0;
        for($i = 0; $i < sizeof($data1); $i++){
            $num += pow($data1[$i]-$data2[$i],2);
        }
        return sqrt($num);
    }

}


