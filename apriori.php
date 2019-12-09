<?php
function combination($member,$num){
  $n = count($member);  
  //jumlah total kombinasi yang mungkin
  $total = pow(2, $n);
  $list =array();
  //Loop untuk setiap kombinasi yang mungkin
  $k=0;
  for ($i = 0; $i < $total; $i++) {  
    $list[$k]=array();
    //Untuk setiap kombinasi, dicek untuk setiap bit
    for ($j = 0; $j < $total; $j++) {  
      //apakah data bit $j ada pada bit $i?  
      if ((pow(2, $j) & $i)) $list[$k][]=$member[$j];      
    }
    if(count($list[$k])==$num){
      //jika jumlah anggota sama dengan jumlah yang diinginkan increment $k
      $k++;
    }else{
      //jika tidak sesuai, hapus array $list[$k]
      unset($list[$k]);
    }
  }
  return $list;
}
//-------------------
function array_consolidate($list){
  $r=$list[0];
  for($i=1;$i<count($list);$i++){
    $r=array_merge($r,$list[$i]);
  }
  $r=array_values(array_unique($r));
  sort($r);
  return $r;
}
//--------------------
function build_candidate($data,$level){
  $result=combination($data,$level);
  sort($result);
  return $result;
}
//-----------------------
function join_step($source,$data){
  $n=count($data[0]);
  for($i=0;$i<count($data);$i++){
    for($j=0;$j<count($source);$j++){
      $freq=array_intersect($source[$j],$data[$i]);
      $support[$i]=(count($freq)==count($data[$i])?
      (isset($support[$i])?$support[$i]+1:1):
      (isset($support[$i])?$support[$i]:0));
    }
  }
  $result=array($data,$support);
  return $result;
}
//-----------------------
function prune_data($data,$no_trans,$min_support){
  $result=array();
  foreach ($data[1] as $key=>$value){
    if($value/$no_trans<$min_support){
      unset($data[0][$key]);
      unset($data[1][$key]);
    }else{
      $result[0][]=$data[0][$key];
      $result[1][]=$data[1][$key];
    }
  }
  return $result;
}
//-----------------------
function print_transaction($data,$title=NULL){
  echo (isset($title)?"<h3>Transaction for {$title}</h3>\n":"");
  echo "<div class='table'>\n"
      ."<span><div class='header'>Trans No</div>"
      ."<div class='header'>Items</div></span>\n";
  for($i=0;$i<count($data);$i++){
    echo "<span><div class='cell'>".($i+1)."</div><div class='cell'>{";
    for($j=0;$j<count($data[$i]);$j++){
      echo ($j==0?"":",").$data[$i][$j];
    }
    echo "}</div></span>\n";
  }    
  echo "</div><br>\n";  
}
//-----------------------
function print_itemset($data,$level,$title=NULL){
  echo (isset($title)?"<h3>Candidate C-{$level}</h3>\n":"");
  echo "<div class='table1'>\n"
      ."<span><div class='header'>{$level}-Itemset</div></span>\n";
  for($i=0;$i<count($data);$i++){
    echo "<span><div class='cell'>{";
    for($j=0;$j<count($data[$i]);$j++){
      echo ($j==0?"":",").$data[$i][$j];
    }
    echo "}</div></span>\n";
  }    
  echo "</div><br>\n";
}
//-----------------------
function print_support($data,$level,$title=NULL){
  echo (isset($title)?"<h3>{$title} {$level}</h3>\n":"");
  if(!empty($data)){
    echo "<div class='table'>\n"
        ."<span><div class='header'>"
        .($level?$level."-":"")
        ."Itemset</div><div class='header'>Count</div></span>\n";
    for($i=0;$i<count($data[0]);$i++){
      echo "<span><div class='cell'>{";
      for($j=0;$j<count($data[0][$i]);$j++){
        echo ($j==0?"":",").$data[0][$i][$j];
      }
      echo "}</div><div class='cell'>{$data[1][$i]}</div></span>\n";
    }    
    echo "</div><br>\n";
  }
}
//-------------------------
function array_rebuild($data){
  $result=array();
  for($i=0;$i<count($data[0]);$i++){
    $result[0][$i]=implode("|",$data[0][$i]);
  }
  $result[1]=$data[1];
  return $result;
}
function get_combinations($base,$n){
  $baselen = count($base);
  if($baselen == 0){
    return;
  }
  if($n == 1){
    $return = array();
    foreach($base as $b){
      $return[] = array($b);
    }
    return $return;
  }else{
    //get one level lower combinations
    $oneLevelLower = get_combinations($base,$n-1);
    /*for every one level lower combinations add one element to them that the last
      element of a combination is preceeded by the element which follows it in base
      array if there is none, does not add*/
    $newCombs = array();
    foreach($oneLevelLower as $oll){
      $lastEl = $oll[$n-2];
      $found = false;
      foreach($base as  $key => $b){
        if($b == $lastEl){
          $found = true;
          continue;
           //last element found
        }
        if($found == true){
          //add to combinations with last element
          if($key < $baselen){
            $tmp = $oll;
            $newCombination = array_slice($tmp,0);
            $newCombination[]=$b;
            $newCombs[] = array_slice($newCombination,0);
          }
        }
      }
    }
  }
  return $newCombs;
}
 
function generate_all($data){
  $result=array();
  $n=count($data);
  //generate kombinasi 1 -> (jumlahdata-1)
  for($i = 1; $i < $n; $i++){
    $combination[$i] = get_combinations($data, $i);
  }
  //set pertama
  //--------------------
  if($n<=2)
  {
    $result[]=$data[0]."->".$data[1];
    $result[]=$data[1]."->".$data[0];
  }
  else
  {
    foreach($combination[2] as $x => $y){
      //simpan kombinasi 2 nya
      $result[]=implode("->", $y);
    }
    //kombinasi 2 dibalik
    $rev_comb_2 = array_reverse($combination[2]); 
    foreach($rev_comb_2 as $x => $y){
      //simpan kombinasi 2 yang sudah dibalik posisinya
      $result[]=implode("->", array_reverse($y));
    }
    //set ke 2,3,4,,,,n
    //--------------------
    for($i = 2; $i < $n; $i++){
      if($i == 2){
        // ini utk set ke 2
        //gabungkan kombinasi 2 dan 1
        $set[$i] = array_merge($combination[2],$combination[1]); 
      }else{ 
        // ini utk set ke 3,4,5, dst...
        //gabungkan kombinasi $i dengan $set[$i-1]
        $set[$i] = array_merge($combination[$i],$set[$i-1]); 
      }
      //set nya dibalik
      $rev_set = array_reverse($set[$i]);
      foreach($set[$i] as $x => $y){
        list($x2, $y2) = each($rev_set);
        //simpan set nya dengan format (set -> set_yg_dibalik)
        $result[]=implode("|", $y)."->".implode("|", $y2);
      }
    }
  }
  return $result;
}
//===================================
 
function get_confidence($data,$x,$y)
{
   $a=explode("|",$x);
   $b=explode("|",$y);
   $xy=array_merge($a,$b);
   $xy=array_values(array_unique($xy));
   sort($xy);
   $data_xy=implode("|",$xy);
   $idx_x=array_keys($data[0],$x);
   $idx_xy=array_keys($data[0],$data_xy);
   if(!empty($idx_x) && !empty($idx_xy)){
      $support_x = $data[1][$idx_x[0]];
      $support_xy = $data[1][$idx_xy[0]];
   }
   $confidence=isset($support_x)?($support_xy / $support_x):0;
   $result=(isset($support_x)?
   array($support_xy,$support_x,$confidence):array(0,0,0));
   return $result;
}
 
function association_rule($data)
{
  $result=array();
  for($i=0;$i<count($data[0]);$i++){
    $x=$data[0][$i];
    if(count($x)>1){
      $result=array_merge($result,generate_all($data[0][$i]));
    }
  }
  $rule=array_values(array_unique($result));
  $a=array_rebuild($data);
  sort($rule);
  $result=array();
  for($i=0;$i<count($rule);$i++){
    $item=explode("->",$rule[$i]);
    $rule[$i]="{".str_replace("|"," ",$rule[$i])."}";
    $rule[$i]=str_replace("->","}->{",$rule[$i]);
    $result[]=array_merge(array($rule[$i]),get_confidence($a,$item[0],$item[1]));
  }
  return $result;
}
//--------------------------------
function print_association_rule($data,$title){
  echo (isset($title)?"<h3>".$title."</h3>\n":"");
  echo "<div class='table_rule'>\n"
      ."<span><div class='header_rule'>Rules</div>"
      ."<div class='header_rule'>Support (XY)</div>"
      ."<div class='header_rule'>Support (X)</div>"
      ."<div class='header_rule'>Confidence</div>"
      ."</span>\n";
  for($i=0;$i<count($data);$i++){
    echo "<span>";
    for($j=0;$j<count($data[$i]);$j++){
      echo "<div class='".($j==0?" left":"cell")."'>"
          .substr($data[$i][$j],0,12)."</div>";
    }
    echo "</span>\n";
  }    
  echo "</div><br>\n";    
}
/***************************/
function apriori($data,$title=NULL){
  echo isset($title)?"<h1>".$title."</h1>":"";
  //echo "<pre>";print_r($data);echo "</pre>";
  print_transaction($data,$title);
  $no_trans=count($data);
  echo "<h2>Step 1: Find all Frequent Itemsets</h2>";
  $result[0]=$data;
  $step=1;
  $frequent_item=array(array(),array());
  do{
    $c=array_consolidate($result[0]);
    //echo "<pre>c-->";print_r($c);echo "</pre>";
    $bl=build_candidate($c,$step);
    //echo "<pre>b_$step-->";print_r($bl);echo "</pre>";
    print_itemset($bl,$step,1);
    $jo=join_step($data,$bl);
    //echo "<pre>j_$step-->";print_r($jo);echo "</pre>";
    print_support($jo,$step,"Join C-");
    $result=prune_data($jo,$no_trans,MIN_SUPPORT);
    $frequent_item[0]=array_merge($frequent_item[0],$result[0]);
    $frequent_item[1]=array_merge($frequent_item[1],$result[1]);
    //echo "<pre>p_$step-->";print_r($result);echo "</pre>";  
    print_support($result,$step,"Prune L-");
    $step++;
  }while(!empty($result) && count($result[0])>1);
  //echo "<pre>frequent_item-->";print_r($frequent_item);echo "</pre>";
  print_support($frequent_item,"","Frequent Itemsets");
  echo "<h2>Step 2: Generate strong association rules from the frequent itemsets</h2>\n";
  echo "\n******************************************************\n";
  $rule=association_rule($frequent_item);
  //echo "<pre>rule-->";print_r($rule);echo "</pre>";
  print_association_rule($rule,"Association Rules");  
}
?>
<!doctype html>
<head>
<title>Apriori Algorithm</title>
<style type="text/css">
span.row {
 width:100%;
 display: table-row;
}
div.table{
 border:solid 1px #999;
 width:200px;
 text-align:center;
 padding:2px;
 -moz-box-shadow:    4px 4px 4px 4px #ccc;
  -webkit-box-shadow: 4px 4px 4px 4px #ccc;
  box-shadow:         4px 4px 4px 4px #ccc;
}
div.table1{
 border:solid 1px #999;
 width:100px;
 text-align:center;
 padding:2px;
 -moz-box-shadow:    4px 4px 4px 4px #ccc;
  -webkit-box-shadow: 4px 4px 4px 4px #ccc;
  box-shadow:         4px 4px 4px 4px #ccc;
}
div.table_rule{
 border:solid 1px #999;
 width:480px;
 text-align:center;
 padding:2px;
 -moz-box-shadow:    4px 4px 4px 4px #ccc;
  -webkit-box-shadow: 4px 4px 4px 4px #ccc;
  box-shadow:         4px 4px 4px 4px #ccc;
}
div.header{
 border:solid 1px #999;
 color:#eee;
 background-color:#333;
 font-weight:bold;
 text-align:center;
 width:100px;
 height:20px;
 display: table-cell;
 padding:2px;
}
div.header_rule{
 border:solid 1px #999;
 color:#eee;
 background-color:#333;
 font-weight:bold;
 text-align:center;
 width:120px;
 height:20px;
 display: table-cell;
 padding:2px;
}
div.cell {
 border:dashed 1px #eee;
 text-align:center;
 width:120px;
 height:20px;
 display: table-cell;
 padding:2px;
}
div.left{
 border:dashed 1px #eee;
 text-align:left;
 width:100px;
 height:20px;
 display: table-cell;
 padding:2px;
 padding-left:5px;
}
</style>
<body>
<div class="container">
<?php
/************************/
define('MIN_SUPPORT',0.5);
define('MIN_CONFIDENCE',0.8);
//-------- EXAMPLE -------
$data1=array(
       array('a','c','d'),
       array('b','c','e'),
       array('a','b','c','e'),
       array('b','e')
      );
apriori($data1,'Example #1');
$data2=array(
       array(1,3,4),
       array(2,3,5),
       array(1,2,5),
       array(2,5)
      );
apriori($data2,'Example #2');
?>
</div>
</body>
</html>                