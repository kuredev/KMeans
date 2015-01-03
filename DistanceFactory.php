<?php

require_once 'Distance.php';
require_once 'EuclidDistance.php';

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DistanceFactory{
    public static function create($distanceName){
        if($distanceName === "tanimoto"){
            return new TanimotoDistance();
        }else if($distanceName === "pearson"){
            
        }else if($distanceName === "Euclid"){
            return new EuclidDistance();
        }
    }
}
