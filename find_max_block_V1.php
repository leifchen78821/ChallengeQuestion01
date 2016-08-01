<?php

header("Content-Type:text/html; charset=utf-8");

$origin = array(
        array(0, 1, 1, 1, 0, 0, 0, 0, 0, 1),
        array(1, 1, 0, 1, 1, 0, 0, 0, 0, 1),
        array(1, 0, 0, 1, 1, 1, 0, 0, 0, 1),
        array(1, 0, 0, 0, 0, 1, 1, 1, 0, 1),
        array(1, 1, 1, 1, 1, 0, 0, 1, 0, 1),
        array(0, 1, 0, 0, 1, 0, 0, 1, 0, 1),
        array(1, 1, 1, 0, 1, 0, 1, 1, 1, 1),
        array(1, 0, 0, 0, 1, 0, 0, 0, 1, 1),
        array(1, 0, 0, 0, 1, 1, 1, 1, 1, 1),
        array(1, 1, 0, 1, 0, 0, 0, 0, 0, 1)
    );
    
    echo "這張地圖的設定是 ...<br><br><br>" ;
    
    for($i = 0 ; $i < 10 ; $i++) {
        for($j = 0 ; $j < 10 ; $j++) {
            echo $origin[$i][$j] . " " ;
        }
        echo "<br>" ;
    }
    
    echo "<br><br>這張地圖放大邊界 ...<br><br><br>" ;
    
    for($i = 0 ; $i < 12 ; $i++) {
        for($j = 0 ; $j < 12 ; $j++) {
            if($i == 0) {
                $origin_change[$i][$j] = 0 ;
            }
            elseif($i == 11) {
                $origin_change[$i][$j] = 0 ;
            }
            elseif($j == 0) {
                $origin_change[$i][$j] = 0 ;
            }
            elseif($j == 11) {
                $origin_change[$i][$j] = 0 ;
            }
            else {
                $origin_change[$i][$j] = $origin[$i-1][$j-1] ;
            }
        }
    }
    
    for($i = 0 ; $i < 12 ; $i++) {
        for($j = 0 ; $j < 12 ; $j++) {
            echo $origin_change[$i][$j] . " " ;
        }
        echo "<br>" ;
    }
    
    echo "<br><br>這張地圖有標記的有 ...<br><br><br>" ;
    
    
    // $$map[$i][$j]  = 是否有1 , 有1疊加 ;
    // $map_size[編號] = 面積 ;
    // $num = 編號 ;
    
    $num = 1 ;
    
    for($i = 0 ; $i < 12 ; $i++) {
        for($j = 0 ; $j < 12 ; $j++) {
            
            if($origin_change[$i][$j] == 1) {
                $map[$i][$j] = $num ;
                $num++;
            }
            else {
                $map[$i][$j] = 0 ;
            }
        }
    }
    
    for($i = 0 ; $i < 12 ; $i++) {
        for($j = 0 ; $j < 12 ; $j++) {
            printf("%02d",$map[$i][$j]) ;
            echo " " ;
        }
        echo "<br>" ;
    }
    
    echo "<br><br>這張地圖石頭彼此相連的有(正刷<右下>) ...<br><br><br>" ;
    // $map_num[$i][$j]  = 編號 ; 
    // $rock_num = 石頭編號 ;
    // $getrock 有石頭相鄰
    
    $rock_num = 1 ;
    $getrock = 0;
    
    for($i = 1 ; $i < 11 ; $i++) {
        for($j = 1 ; $j < 11 ; $j++) {
            
            if($origin_change[$i][$j] == 1) {
                    
                // 檢查上下左右是否有1
                // 上
                $map_num[$i][$j] = $rock_num ;
                
                if($origin_change[$i-1][$j] != 0 ) {
                    $map_num[$i][$j] = $map_num[$i-1][$j] ;
                    // $map_num[$i][$j] = 1 ;
                }
                // 右
                // elseif($origin_change[$i][$j+1] != 0) {
                //     $map_num[$i][$j] = $map_num[$i][$j+1] ;
                //     // $map_num[$i][$j] = 2 ;
                // }
                // // 下
                // elseif($origin_change[$i+1][$j] != 0) {
                //     $map_num[$i][$j] = $map_num[$i+1][$j] ;
                // }
                // 左
                elseif($origin_change[$i][$j-1] != 0) {
                    $map_num[$i][$j] = $map_num[$i][$j-1] ;
                    // $map_num[$i][$j] = 4 ;
                }
                else {
                    // $map_num[$i][$j] = $rock_num;
                    // $rock_num++;
                    // $map_num[$i][$j] = 5 ;

                    $map_num[$i][$j] = $rock_num ;
                    $rock_num++;
                }
            }
            else {
                $map_num[$i][$j] = 0 ;
            }
        }
    }
    
    for($i = 0 ; $i < 12 ; $i++) {
        for($j = 0 ; $j < 12 ; $j++) {
            if($map_num[$i][$j] == 0) {
                if($i == 0 || $j == 0) {
                    echo "＊" ;
                }
                elseif($i == 11 || $j == 11) {
                    echo "＊" ;
                }
                else {
                    echo "口" ;
                }
            }
            else {
                printf("%02d",$map_num[$i][$j]) ;
            }
            echo " " ;
        }
        echo "<br>" ;
    }
    
    // echo "<br><br>這張地圖石頭彼此相連的有(反刷<左上>) ...<br><br><br>" ;
    // // $map_num[$i][$j]  = 編號 ; 
    // // $rock_num = 石頭編號 ;
    // // $getrock 有石頭相鄰
    // $rock_num--;
    
    // for($i = 10 ; $i > 0 ; $i--) {
    //     for($j = 10 ; $j > 0 ; $j--) {
            
    //         if($origin_change[$i][$j] == 1) {
                    
    //             // 檢查上下左右是否有1
    //             // 上
    //             $map_num[$i][$j] = $rock_num ;
                
    //             // if($origin_change[$i-1][$j] != 0 ) {
    //             //     $map_num[$i][$j] = $map_num[$i-1][$j] ;
    //             //     // $map_num[$i][$j] = 1 ;
    //             // }
    //             // 右
    //             if($origin_change[$i][$j+1] != 0) {
    //                 $map_num[$i][$j] = $map_num[$i][$j+1] ;
    //                 // $map_num[$i][$j] = 2 ;
    //             }
    //             // 下
    //             elseif($origin_change[$i+1][$j] != 0) {
    //                 $map_num[$i][$j] = $map_num[$i+1][$j] ;
    //             }
    //             // 左
    //             // elseif($origin_change[$i][$j-1] != 0) {
    //             //     $map_num[$i][$j] = $map_num[$i][$j-1] ;
    //                 // $map_num[$i][$j] = 4 ;
    //             // }
    //             else {
    //                 // $map_num[$i][$j] = $rock_num;
    //                 // $rock_num++;
    //                 // $map_num[$i][$j] = 5 ;
    //                 $map_num[$i][$j] = $rock_num ;
    //                 $rock_num--;
    //             }
                
                
                
    //         }
    //         else {
    //             $map_num[$i][$j] = 0 ;
    //         }
    //     }
    // }
    
    // for($i = 0 ; $i < 12 ; $i++) {
    //     for($j = 0 ; $j < 12 ; $j++) {
    //         if($map_num[$i][$j] == 0) {
    //             if($i == 0 || $j == 0) {
    //                 echo "＊" ;
    //             }
    //             elseif($i == 11 || $j == 11) {
    //                 echo "＊" ;
    //             }
    //             else {
    //                 echo "口" ;
    //             }
    //         }
    //         else {
    //             printf("%02d",$map_num[$i][$j]) ;
    //         }
    //         echo " " ;
    //     }
    //     echo "<br>" ;
    // }
    
    echo "<br><br>這張地圖石頭彼此相連合併 ...<br><br><br>" ;
    for($merge = 0 ; $merge < 10000 ; $merge++) {
        for($i = 1 ; $i < 11 ; $i++) {
            for($j = 1 ; $j < 11 ; $j++) {
                
                if($map_num[$i][$j] != 0) {
                        
                    // 檢查下右是否有1
                    // 右
                    $change = 0 ;
                    if($map_num[$i][$j+1] != 0) {
                        if($map_num[$i][$j+1] != $map_num[$i][$j]) {
                            $map_num[$i][$j] = $map_num[$i][$j+1] ;
                            $change = 1 ;
                        }
                    }
                    // 下
                    elseif($map_num[$i+1][$j] != 0) {
                        if($map_num[$i+1][$j] != $map_num[$i][$j]) {
                            $map_num[$i][$j] = $map_num[$i+1][$j] ;
                            $change = 1 ;
                        }
                    }
                    if($change == 0) {
                        // 左
                        if($map_num[$i-1][$j] != 0) {
                            if($map_num[$i][$j-1] != $map_num[$i][$j]) {
                                $map_num[$i][$j] = $map_num[$i-1][$j] ;
                            }
                        }
                        // 上
                        elseif($map_num[$i][$j-1] != 0) {
                            if($map_num[$i][$j-1] != $map_num[$i][$j]) {
                                $map_num[$i][$j] = $map_num[$i][$j-1] ;
                            }
                        }
                    }
                }
            }
        }
    }
    for($i = 0 ; $i < 12 ; $i++) {
        for($j = 0 ; $j < 12 ; $j++) {
            if($map_num[$i][$j] == 0) {
                if($i == 0 || $j == 0) {
                    echo "＊" ;
                }
                elseif($i == 11 || $j == 11) {
                    echo "＊" ;
                }
                else {
                    echo "口" ;
                }
            }
            else {
                printf("%02d",$map_num[$i][$j]) ;
            }
            echo " " ;
        }
        echo "<br>" ;
    }
    
    echo "<br><br>計算各石頭面積 ...<br><br><br>" ;
    // $rockarea[x][y][編號] = 石頭面積
    
    for($i = 1 ; $i < 11 ; $i++) {
        for($j = 1 ; $j < 11 ; $j++) {
            
            if($map_num[$i][$j] != 0) {
                    
                $rockarea[$map_num[$i][$j]]++;
                
            }
        }
    }
    
    for($i = 0 ; $i < 12 ; $i++) {
        for($j = 0 ; $j < 12 ; $j++) {
            if($map_num[$i][$j] == 0) {
                if($i == 0 || $j == 0) {
                    echo "＊" ;
                }
                elseif($i == 11 || $j == 11) {
                    echo "＊" ;
                }
                else {
                    echo "口" ;
                }
            }
            else {
                printf("%02d",$rockarea[$map_num[$i][$j]]) ;
            }
            echo " " ;
        }
        echo "<br>" ;
    }
?>