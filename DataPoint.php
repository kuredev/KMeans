<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DataPoint extends Point {

    private $belongClusterPoint; //所属しているクラスタ（ポイント）
    private $belongClusterDistance;//所属しているクラスタとの距離
    
   
    /**
     * 
     * @param array $clusterPointArr CentroidPoint[]
     * @param type $distance DistanceInterface
     */
    public function belongCluster(array $clusterPointArr, DistanceInerface $distance) {
        foreach ($clusterPointArr as $clusterPoint){
            $distanceWithClusterPoint = $distance->distance($clusterPoint->getCoordinate(), $this->coordinates);
            if($this->belongClusterDistance === null | $this->belongClusterDistance > $distanceWithClusterPoint){
                $this->belongClusterDistance = $distanceWithClusterPoint;
                $this->belongClusterPoint = $clusterPoint;
            }
        }
        $this->belongClusterPoint->addDataPoint($this);//**
    }
    
    public function showBelongCluster(){
        
    }
    
    /**
     * 
     * @return type
     */
    public function getBelongClusterPoint(){
        return $this->belongClusterPoint;
    }
    
    public function __toString(){
        echo "DataPoint\n";
        echo "座標\n";
        var_dump($this->coordinates);
        echo "クラスタとの距離\n";
        var_dump($this->belongClusterDistance);
    }

}
