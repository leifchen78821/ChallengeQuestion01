<?PHP
header("Content-Type:text/html; charset=utf-8");

$origin = array(
    array(1, 1, 0, 0, 0, 0, 0, 0, 0, 0),
    array(1, 1, 0, 1, 1, 0, 0, 0, 0, 0),
    array(0, 0, 0, 1, 1, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 1, 1, 1, 0, 0),
    array(1, 1, 0, 1, 1, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 1, 0, 0, 0, 0, 0),
    array(1, 1, 1, 0, 1, 0, 1, 0, 0, 1),
    array(1, 0, 0, 0, 0, 0, 1, 0, 0, 1),
    array(0, 0, 0, 0, 1, 0, 1, 0, 1, 1),
    array(1, 1, 0, 1, 1, 0, 1, 0, 0, 0)
);

class Block{
     
     public $origin = null;
     public $alreadySearched = array();
     function setOrigin($origin){
          $this->origin = $origin;
     }
     function drawBlock(){
          $maxRow = sizeof($this->origin);
          $maxCol = sizeof($this->origin[$maxRow-1]);
     
          echo "<div class='originBlockBox'>";
          for($row = 0; $row < $maxRow; $row++){
               for($col = 0; $col < $maxCol; $col++){
                    if($this->origin[$row][$col] == 1 ){
                         echo "<div class='block block_black'>1</div>";
                    }else{
                         echo "<div class='block'>0</div>";
                    }
               }
          }
          echo "</div>";
     }
     
     function findAllMinBlock(){
          $maxRow = sizeof($this->origin);
          $maxCol = sizeof($this->origin[$maxRow-1]);
          
          for($row = 0; $row < $maxRow; $row++){
               for($col = 0; $col < $maxCol; $col++){
                    if($this->origin[$row][$col] == 1){
                         $blockBox = array();
                         $block['row'] = $row;
                         $block['col'] = $col;
                         $blockBox[] = $block;
                         $blockArray[] = $blockBox;
                    }
               }
          }
          return $blockArray;
     }
     
     function drawBlockByLocation($block){
          $maxRow = sizeof($this->origin);
          $maxCol = sizeof($this->origin[$maxRow-1]);
     
          echo "<div class='blockBox'>";
          for($row = 0; $row < $maxRow; $row++){
               for($col = 0; $col < $maxCol; $col++){
                    $currentBlock = array("row" => $row, "col" => $col );
                    if(in_array($currentBlock, $block)){
                         echo "<div class='block block_black'>1</div>";
                    }else{
                         echo "<div class='block'>0</div>";
                    }
               }
          }
          echo "</div>";
     }
     
     function findMaxBlock($newBlockArray){
          $score = 0;
          $maxBlockBox = array();
          foreach($newBlockArray as $blockBox){
               if(sizeof($blockBox) > $score){
                    $maxBlockBox = array();
                    $score = sizeof($blockBox);
                    $maxBlockBox[] = $blockBox;
               }else if(sizeof($blockBox) == $score){
                    $maxBlockBox[] = $blockBox;
               }
          }
          
          return $maxBlockBox;
     }
     
     function getBlock($row, $col){
          $block['row'] = $row;
          $block['col'] = $col;
          return $block;
     }
}
?>
<html>
     <head>
          <style>
               body{
                    margin: 0 auto;
                    text-align: center;
               }
               .block{
                    width: 20px;
                    height: 20px;
                    margin: 0px 0px 0px 0px;
                    padding: 0px;
                    float: left;
                    border: 1px solid black;
               }
               .block_black{
                    background: black;
                    border: 1px solid white;
                    color: white;
               }
               .originBlockBox{
                    width: 220px;
                    height: 220px;
                    border: 2px solid blue;
                    margin: 0 auto;
               }
               .blockBox_div{
                    width: 705px;
                    margin: 0 auto;
                    padding: 0px;
               }
               .blockBox{
                    width: 220px;
                    height: 220px;
                    border: 2px solid blue;
                    margin: 5px 5px;
                    float: left;
               }
               .title{
                    color: blue;
                    font-size: 20px;
                    margin: 0 auto;
                    font-weight: bold;
                    padding-top: 10px;
                    padding-bottom: 10px;
               }
          </style>
     </head>
     <body>
          <?php 
               $blockClass = new Block(); 
               $blockClass->setOrigin($origin);
          ?>
          
          <div class="title">Origin</div>
          <?php $blockClass->drawBlock(); ?>
          <div class="title">Find Max Block</div>
          <?php //$maxBlock = $blockClass->findMaxBlock($origin); ?>
          <?php //$blockClass->drawBlock($maxBlock); ?>
          <?php 
          $t1 = microtime(true);
          $blockArray = $blockClass->findAllMinBlock();
          $newBlockArray = array();
          
          for($index = 0; $index < sizeof($blockArray); $index++){
               $blockBox = $blockArray[$index];
               $isNeedSave = false;
               for($i = 0; $i < sizeof($blockBox); $i++){
                    $block = $blockBox[$i];
                    if(in_array($block, $blockClass->alreadySearched)){
                         break;
                    }else{
                         if(  $blockClass->origin[$block['row']][$block['col']] == 1){
                              $isNeedSave = true;
                              $blockClass->alreadySearched[] = $block;
                              $rightBlock = $blockClass->getBlock($block['row'], $block['col']);
                              if(!in_array($rightBlock, $blockBox)){
                                   $blockBox[] = $rightBlock;
                              }
                         }
                         if(  $blockClass->origin[$block['row']][$block['col']+1] == 1){
                              $isNeedSave = true;
                              $blockClass->alreadySearched[] = $block;
                              $rightBlock = $blockClass->getBlock($block['row'], $block['col']+1);
                              if(!in_array($rightBlock, $blockBox)){
                                   $blockBox[] = $rightBlock;
                              }
                         }
                         if(  $blockClass->origin[$block['row']][$block['col']-1] == 1){
                              $isNeedSave = true;
                              $blockClass->alreadySearched[] = $block;
                              $rightBlock = $blockClass->getBlock($block['row'], $block['col']-1);
                              if(!in_array($rightBlock, $blockBox)){
                                   $blockBox[] = $rightBlock;
                              }
                         }
                         if(  $blockClass->origin[$block['row']+1][$block['col']] == 1){
                              $isNeedSave = true;
                              $blockClass->alreadySearched[] = $block;
                              $rightBlock = $blockClass->getBlock($block['row']+1, $block['col']);
                              if(!in_array($rightBlock, $blockBox)){
                                   $blockBox[] = $rightBlock;
                              }
                         }
                         if(  $blockClass->origin[$block['row']-1][$block['col']] == 1){
                              $isNeedSave = true;
                              $blockClass->alreadySearched[] = $block;
                              $rightBlock = $blockClass->getBlock($block['row']-1, $block['col']);
                              if(!in_array($rightBlock, $blockBox)){
                                   $blockBox[] = $rightBlock;
                              }
                         }
                    }
               }
               
               if($isNeedSave){
                    $newBlockArray[] = $blockBox;
               }
          }
          
          $maxBlockBox = $blockClass->findMaxBlock($newBlockArray);
          
         // $blockClass->drawBlockByLocation($maxBlockBox);
         
          $t2 = microtime(true);
          
          echo "最大區塊數：" . sizeof($maxBlockBox) . "<br>";
          echo "最大格數：" . sizeof($maxBlockBox[0]) . "<br>";
          echo "耗時：" . number_format((($t2-$t1)*1000), 3) . ' s<br>';
          echo "<div class='blockBox_div'>";
          foreach($maxBlockBox as $blocks){
               $blockClass->drawBlockByLocation($blocks);
          }
          echo "</div>";
          ?>
     </body>
</html>