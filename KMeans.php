<?php

error_reporting(E_ALL & ~E_NOTICE);

function __autoload($class_name) {
    include $class_name . '.php';
}

/**
 * 条件：
 * 用いるデータは自然数に限る
 * データは入れ子配列で入力する
 */
class KMeans implements KMeansInterface {

    public function __construct() {}

    /**
     * 
     * @param array $dataArr
     * @param type $k
     * @param type $distanceName
     * @return array
     */
    public function cluster(array $dataArr, $k, $distanceName) {
        $vectorDimensionNum = count($dataArr[0]);
        $clusterPointArr = array();
        $savedClusterPointArr = array();
        $dataPointArr = array();
        foreach ($dataArr as $data) {
            array_push($dataPointArr, new DataPoint($data));
        }
        
        //1.初期クラスタポイント（中心点）を作成
        while(1){
            $randArr = $this->_getRandPointArr(
                    $this->_getRange($dataPointArr,$vectorDimensionNum), 
                    $k, 
                    $vectorDimensionNum);
            if($this->_chkDupValue($randArr) == false){
                break;
            }            
        }
        foreach ($randArr as $rand) {
            array_push($clusterPointArr, new ClusterPoint($rand));
        }

        //Phase2. calc distance...
        //
        $this->_belongCluster($clusterPointArr, $dataPointArr, $distanceName);
        $this->_saveClusterPoint($clusterPointArr, $savedClusterPointArr);
        while (1) {
            $this->_moveClusterPoint($clusterPointArr);
            if (!$this->_chkMovedClusterPoint($clusterPointArr, $savedClusterPointArr)) {
                break;
            }
            $this->_flushBelongCluster($clusterPointArr);
            $this->_belongCluster($clusterPointArr, $dataPointArr, $distanceName);
            $this->_saveClusterPoint($clusterPointArr, $savedClusterPointArr);
        }
                
        return $clusterPointArr;
    }

    /**
     * 
     * @param type $clusterPointArr
     */
    private function _flushBelongCluster(&$clusterPointArr) {
        foreach ($clusterPointArr as $clusterPoint) {
            $clusterPoint->flushBelongDataPoints();
        }
    }

    /**
     * 重複があったらtrue
     * @param type $arr
     * @return boolean
     */
    private function _chkDupValue($arr) {
        $arrVCount = array_count_values($arr);
        for ($i = 0; $i < count($arr); $i++) {
            $key = $arr[$i];
            $count = $arrVCount[$key];
            if ($count > 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * 
     * @param type $clusterPointArr
     * @param type $dataPointArr
     * @param type $distanceName
     */
    private function _belongCluster($clusterPointArr, &$dataPointArr, $distanceName) {
        foreach ($dataPointArr as $dataPoint) {
            $dataPoint->belongCluster(
                    $clusterPointArr, 
                    DistanceFactory::create($distanceName));
        }
    }

    /**
     * 
     * @param type $clusterPointArr
     * @param type $savedClusterPointArr
     */
    private function _saveClusterPoint($clusterPointArr, &$savedClusterPointArr) {
        for ($i = 0; $i < sizeof($clusterPointArr); $i++) {
            $savedClusterPointArr[$i] = clone $clusterPointArr[$i];
        }
    }

    /**
     * 
     * @return boolean 前回のポイントと動いていたらtrue
     */
    private function _chkMovedClusterPoint($clusterPointArr, $savedClusterPointArr) {
        for ($i = 0; $i < sizeof($clusterPointArr); $i++) {
            $diff = array_diff(
                    $clusterPointArr[$i]->getCoordinate(),
                    $savedClusterPointArr[$i]->getCoordinate());
            if ($diff != null) {
                return true;
            }
        }

        return false;
    }

    /**
     * 
     * @param type $clusterPointArr
     */
    private function _moveClusterPoint(&$clusterPointArr) {
        foreach ($clusterPointArr as $clusterPoint) {
            $aveArr = $this->_calcAve($clusterPoint->getBelongDataPoints());
            if($aveArr == null) continue;
            $clusterPoint->moveCoodinate($aveArr);
        }
    }

    /**
     * 
     * @param type $dataPointArr
     * @return type
     */
    private function _calcAve($dataPointArr) {//ここがカラ！！
        if($dataPointArr == null) return null;
        
        $sumArr = array();
        $arrSize = sizeof($dataPointArr[0]->getBelongClusterPoint()->getBelongDataPoints());//0の場合エラーになる
        foreach ($dataPointArr as $dataPoint) {
            $sumArr = $this->_addArr($sumArr, $dataPoint->getCoordinate());
        }
        return $this->_divArr($sumArr, $arrSize);
    }

    private function _divArr($arr, $num) {
        $result = array();
        for ($i = 0; $i < sizeof($arr); $i++) {
            $result[$i] = $arr[$i] / $num;
        }
        return $result;
    }

    /**
     * 配列同士（各値）の足し算
     * @param type $arr1
     * @param type $arr2
     */
    private function _addArr($arr1, $arr2) {
        $result = array();
        for ($i = 0; $i < count($arr2); $i++) {
            $result[$i] = $arr1[$i] + $arr2[$i];
        }
        return $result;
    }

    /**
     * 
     * @param type $rangeArr
     * @param type $k
     * @return type
     */
    private function _getRandPointArr($rangeArr, $k, $vectorDimensionNum) {
        $randArrArr = array();
        for ($i = 0; $i < $k; $i++) {
            $randArr = array(); //int array
            for ($j = 0; $j < $vectorDimensionNum; $j++) {
                $randArr[$j] = rand($rangeArr[$j][0], $rangeArr[$j][1]);
            }
            $randArrArr[$i] = $randArr;
        }
        return $randArrArr;
    }

    /**
     * 
     * @param type $dataPointArr
     * @param type $vectorDimensionNum
     * @return type
     */
    private function _getRange($dataPointArr, $vectorDimensionNum) {
        $n = $vectorDimensionNum;
        $rangeArr = array();

        for ($i = 0; $i < $n; $i++) {
            //n要素目について
            foreach ($dataPointArr as $dataPoint) {
                $data = $dataPoint->getCoordinate()[$i];
                //[]について
                if ($rangeArr[$i][0] === null || $rangeArr[$i][0] >= $data) {
                    $rangeArr[$i][0] = $data;
                }
                if ($rangeArr[$i][1] === null || $rangeArr[$i][1] <= $data) {
                    $rangeArr[$i][1] = $data;
                }
            }
        }
        return $rangeArr;
    }
}

$kmeans = new KMeans();
var_dump($kmeans->cluster(
        array(
/*    array(1, 1),
    array(1, 2),
    array(2, 1),
    array(5, 5),
    array(5, 6),
    array(6, 5)*/
            array(1,1,1),
            array(1,1,0),
            array(0,0,0),
            array(0,0,1)
        )
        , 2, "Euclid"
        ));

