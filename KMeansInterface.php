<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author root
 */
interface KMeansInterface {
    //put your code here
    
    public function __construct();
    public function cluster(array $dataArr, $k, $distanceName);
}
