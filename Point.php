<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Point{
    protected $coordinates = array();//(1,1,0)
    
    public function __construct(array $coordinates) {
        $this->coordinates = $coordinates;
    }
    
    /**
     * 
     * @param type $coordinates
     */
    public function moveCoodinate($coordinates){
        
        $this->coordinates = $coordinates;
    }
    
    /**
     * 
     * @return type
     */
    public function getCoordinate(){
        return $this->coordinates;
    }
    
    /**
     * 
     * @return type
     */
    public function getVectorDimensionNum(){
   //     var_dump($this->coordinates);
    //    var_dump(count($this->coordinates));
        return count($this->coordinates);
    }

}

