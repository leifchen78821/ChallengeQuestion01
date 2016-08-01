<?php
header("Content-Type:text/html; charset=utf-8");

$origin = array(
        array(0, 1, 0, 0, 1, 0, 1, 1, 1, 1),
        array(1, 1, 0, 1, 1, 0, 0, 0, 0, 1),
        array(0, 0, 0, 0, 1, 0, 0, 0, 0, 0),
        array(1, 0, 0, 0, 1, 0, 0, 0, 0, 1),
        array(0, 1, 1, 1, 1, 0, 1, 1, 1, 1),
        array(0, 0, 1, 0, 0, 1, 0, 0, 0, 1),
        array(1, 0, 1, 1, 0, 1, 1, 1, 0, 1),
        array(0, 0, 0, 0, 1, 0, 0, 0, 0, 0),
        array(1, 0, 0, 0, 0, 0, 1, 1, 1, 1),
        array(1, 1, 0, 1, 1, 0, 0, 0, 0, 1)
    );
    
    // -----------------------------------------------------------------------------
    // 邏輯解析
    // 
    // $findAllRocks( 0.全部編號 , 1.石頭編號 , 2.row , 3.col , 4.群集編號 , 5.群集大小)
    // 
    // 1. 
    // -----------------------------------------------------------------------------
    echo "原本陣列------------------------------------------------<br>" ;
    
    for($row = 0 ; $row < 10 ; $row++) {
        for($col = 0 ; $col < 10 ; $col++) {
            if($origin[$row][$col] == 1) {
                echo "１" ;
            }
            else {
                echo "口" ;
            }
            echo "," ;
        }
        echo "<br>" ;
    }
    
    echo "<br>";
    
    echo "設定編號,陣列------------------------------------------------<br>" ;
    // $findAllRocks( 0.全部編號 , 1.石頭編號 , 2.row , 3.col , 4.群集編號 , 5.群集大小)
    
    $num = 1 ;
    $rockNum = 1 ;
    for($row = 0 ; $row < 10 ; $row++) {
        for($col = 0 ; $col < 10 ; $col++) {
            if($origin[$row][$col] == 1) {
                $findAllRocks[$num][0] = $num ;
                $findAllRocks[$num][1] = $rockNum ;
                $findAllRocks[$num][2] = $row ;
                $findAllRocks[$num][3] = $col ;
                $rockNum++ ;
            }
            else {
                $findAllRocks[$num][0] = $num ;
                $findAllRocks[$num][1] = 0 ;
                $findAllRocks[$num][2] = $row ;
                $findAllRocks[$num][3] = $col ;
            }
            $num++ ;
        }
    }
    
    $num = 1 ;
    for($row = 0 ; $row < 10 ; $row++) {
        for($col = 0 ; $col < 10 ; $col++) {
            if($findAllRocks[$num][1] != 0) {
                printf("%02d",$findAllRocks[$num][1]) ;
            }
            else {
                echo "口" ;
            }
            $num++ ;
            echo "," ;
        }
        echo "<br>" ;
    }
    
    echo "<br>";
    
    $num = 1 ;
    for($row = 0 ; $row < 10 ; $row++) {
        for($col = 0 ; $col < 10 ; $col++) {
            if($findAllRocks[$num][1] != 0) {
                printf("(%02d , %02d)",$findAllRocks[$num][2],$findAllRocks[$num][3]) ;
            }
            else {
                echo "(口 , 口)" ;
            }
            $num++ ;
            echo "," ;
        }
        echo "<br>" ;
    }
    
    echo "進行第一次群聚------------------------------------------------<br>" ;
    // $findAllRocks( 0.全部編號 , 1.石頭編號 , 2.row , 3.col , 4.群集編號 , 5.群集大小)
    
    $num = 1 ;
    $groupNum = 1 ;
    for($row = 0 ; $row < 10 ; $row++) {
        for($col = 0 ; $col < 10 ; $col++) {
            
            if($origin[$row][$col] == 0) {
                $RocksChecked[$row][$col] = 2 ;
                
                $findAllRocks[$num][4] = 0 ;
            }
            else {
                // 上
                if($RocksChecked[$row-1][$col] == 1) {
                    $RocksChecked[$row][$col] = 1 ;
                    
                    for($countnum = 1 ; $countnum < 101 ; $countnum++) {
                        if($findAllRocks[$countnum][2] == $row-1 && $findAllRocks[$countnum][3] == $col) {
                            $tempNum = $findAllRocks[$countnum][0] ;
                            $tempGroupNum = $findAllRocks[$countnum][4] ;
                            $tempGroupSize = $findAllRocks[$countnum][5] ;
                        }
                    }
                    $findAllRocks[$num][4] = $tempGroupNum;
                    $findAllRocks[$num][5] = $tempGroupSize+1 ;
                    for($countnum = 1 ; $countnum < 101 ; $countnum++) {
                        if($findAllRocks[$countnum][4] == $findAllRocks[$num][4]) {
                            $findAllRocks[$countnum][5] = $findAllRocks[$num][5] ;
                        }
                    }

                }
                // 右
                elseif($RocksChecked[$row][$col+1] == 1) {
                    $RocksChecked[$row][$col] = 1 ;
                    
                    for($countnum = 1 ; $countnum < 101 ; $countnum++) {
                        if($findAllRocks[$countnum][2] == $row && $findAllRocks[$countnum][3] == $col+1) {
                            $tempNum = $findAllRocks[$countnum][0] ;
                            $tempGroupNum = $findAllRocks[$countnum][4] ;
                            $tempGroupSize = $findAllRocks[$countnum][5] ;
                        }
                    }
                    $findAllRocks[$num][4] = $tempGroupNum;
                    $findAllRocks[$num][5] = $tempGroupSize+1 ;
                    for($countnum = 1 ; $countnum < 101 ; $countnum++) {
                        if($findAllRocks[$countnum][4] == $findAllRocks[$num][4]) {
                            $findAllRocks[$countnum][5] = $findAllRocks[$num][5] ;
                        }
                    }

                }
                // 下
                elseif($RocksChecked[$row+1][$col] == 1) {
                    $RocksChecked[$row][$col] = 1 ;
                    
                    for($countnum = 1 ; $countnum < 101 ; $countnum++) {
                        if($findAllRocks[$countnum][2] == $row+1 && $findAllRocks[$countnum][3] == $col) {
                            $tempNum = $findAllRocks[$countnum][0] ;
                            $tempGroupNum = $findAllRocks[$countnum][4] ;
                            $tempGroupSize = $findAllRocks[$countnum][5] ;
                        }
                    }
                    $findAllRocks[$num][4] = $tempGroupNum;
                    $findAllRocks[$num][5] = $tempGroupSize+1 ;
                    for($countnum = 1 ; $countnum < 101 ; $countnum++) {
                        if($findAllRocks[$countnum][4] == $findAllRocks[$num][4]) {
                            $findAllRocks[$countnum][5] = $findAllRocks[$num][5] ;
                        }
                    }

                }
                // 左
                elseif($RocksChecked[$row][$col-1] == 1) {
                    $RocksChecked[$row][$col] = 1 ;
                    
                    for($countnum = 1 ; $countnum < 101 ; $countnum++) {
                        if($findAllRocks[$countnum][2] == $row && $findAllRocks[$countnum][3] == $col-1) {
                            $tempNum = $findAllRocks[$countnum][0] ;
                            $tempGroupNum = $findAllRocks[$countnum][4] ;
                            $tempGroupSize = $findAllRocks[$countnum][5] ;
                        }
                    }
                    $findAllRocks[$num][4] = $tempGroupNum;
                    $findAllRocks[$num][5] = $tempGroupSize+1 ;
                    for($countnum = 1 ; $countnum < 101 ; $countnum++) {
                        if($findAllRocks[$countnum][4] == $findAllRocks[$num][4]) {
                            $findAllRocks[$countnum][5] = $findAllRocks[$num][5] ;
                        }
                    }

                }
                
                else {
                    $RocksChecked[$row][$col] = 1 ;
                    $groupSize = 1 ;
                    $findAllRocks[$num][4] = $groupNum ;
                    $findAllRocks[$num][5] = $groupSize ;
                    $groupNum++ ;
                }
            }
            $num++;
        }
    }
    
    $num = 1 ;
    for($row = 0 ; $row < 10 ; $row++) {
        for($col = 0 ; $col < 10 ; $col++) {
            if($origin[$row][$col] != 0) {
                printf("%02d %02d",$findAllRocks[$num][4],$findAllRocks[$num][5]) ;
            }
            else {
                echo "口 口" ;
            }
            $num++;
            echo "," ;
        }
        echo "<br>" ;
    }
    
    echo "將群聚向右聚合(大吃小)------------------------------------------------<br>" ;
    // $findAllRocks( 0.全部編號 , 1.石頭編號 , 2.row , 3.col , 4.群集編號 , 5.群集大小)
    
    $num = 1 ;
    $groupNum = 1 ;
    for($countnum = 1 ; $countnum < 101 ; $countnum++) {
        $row = $findAllRocks[$countnum][2] ;
        $col = $findAllRocks[$countnum][3] ;
        $group = $findAllRocks[$countnum][4] ;
        $groupSize = $findAllRocks[$countnum][5] ;
        $goto = 0 ;
        // 右
        for($i = 1 ; $i < 101 ; $i++) {
            if($findAllRocks[$i][2] == $row && $findAllRocks[$i][3] == $col+1) {
                $rightrow = $findAllRocks[$i][2] ;
                $rightcol = $findAllRocks[$i][3] ;
                $rightgroup = $findAllRocks[$i][4] ;
                $rightgroupSize = $findAllRocks[$i][5] ;
                $goto = 1 ;
            }
        }
        if ($goto == 1) {
            if($rightgroup != $group && $rightgroup != 0 && $group != 0) {
                $totalgroupSize = $rightgroupSize + $groupSize ;
                if($rightgroupSize >= $groupSize) {
                    // $totalgroupSize = $rightgroupSize + $groupSize ;
                    for($j = 1 ; $j < 101 ; $j++) {
                        if($findAllRocks[$j][4] == $group) {
                            $findAllRocks[$j][4] = $rightgroup ;
                            $findAllRocks[$j][5] = $totalgroupSize ;
                        }
                        elseif($findAllRocks[$j][4] == $rightgroup) {
                            $findAllRocks[$j][5] = $totalgroupSize ;
                        }
                    }
                }
                else {
                    for($k = 1 ; $k < 101 ; $k++) {
                        if($findAllRocks[$k][4] == $rightgroup) {
                            $findAllRocks[$k][4] = $group ;
                            $findAllRocks[$k][5] = $totalgroupSize ;
                        }
                        elseif($findAllRocks[$k][4] == $group) {
                            $findAllRocks[$k][5] = $totalgroupSize ;
                        }
                    }
                }
            }
        }
    }
    
    $num = 1 ;
    for($row = 0 ; $row < 10 ; $row++) {
        for($col = 0 ; $col < 10 ; $col++) {
            if($origin[$row][$col] != 0) {
                printf("%02d %02d",$findAllRocks[$num][4],$findAllRocks[$num][5]) ;
            }
            else {
                echo "口 口" ;
            }
            $num++;
            echo "," ;
        }
        echo "<br>" ;
    }
    
    echo "整理結果------------------------------------------------<br>" ;
    
    $num = 1 ;
    for($row = 0 ; $row < 10 ; $row++) {
        for($col = 0 ; $col < 10 ; $col++) {
            if($origin[$row][$col] != 0) {
                printf("%02d",$findAllRocks[$num][5]) ;
            }
            else {
                echo "口" ;
            }
            $num++;
            echo "," ;
        }
        echo "<br>" ;
    }
    
    echo "取最大面積------------------------------------------------<br>" ;
    $maxSize = 0 ;
    for($i = 1 ; $i < 101 ; $i++) {
        if($findAllRocks[$i][5] > $maxSize) {
            $maxSize = $findAllRocks[$i][5] ;
        }
    }
    
    $num = 1 ;
    for($row = 0 ; $row < 10 ; $row++) {
        for($col = 0 ; $col < 10 ; $col++) {
            if($findAllRocks[$num][5] == $maxSize) {
                echo "１" ;
            }
            else {
                echo "口" ;
            }
            $num++;
            echo "," ;
        }
        echo "<br>" ;
    }
?>