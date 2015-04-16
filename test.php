<?php

set_include_path(realpath(dirname(__FILE__)));

include "Lottery/Entity.php";
include "Lottery/List.php";

include "Lottery.php";
include "Lottery/SimpleRandom.php";
include "Lottery/AliasMethod.php";
include "Lottery/DynamicProbability.php";


include "LotteryGame.php";


$list = new Lottery_List(time(), strtotime("+1 day"));
for($i=1; $i<11; $i++) {
	$entity = new Lottery_Entity($i, "Lottery$i", $i, $i/1000);
	$list -> setEntity($entity);
	unset($entity);
}



/*
//T1:
$ = new Lottery_SimpleRandom(1, 10);	
$l = new Lottery($);
$r = array();
for ($i=1; $i<1000; $i++) {
	$id = $l->run();
	$r[$id] = isset($r[$id]) ? $r[$id]+1 : 1;
}
var_dump($r);
*/

/*
//T2:
$ = new Lottery_RandomAlgorithm($lotteryPrizeSequeue);	
$l = new Lottery($);
for ($i=1; $i<100; $i++) {
	$prize = $l->getPrize();
	if ($prize) 
		echo $prize->getName() . "\n";
}
*/










/*

for($i=1; $i<1000; $i++) {
	$fixed = mt_rand(10,125);
	$ = new Lottery_FixedLengthAlgorithm($prizes, $fixed, $max, $i);
	$l = new Lottery($);
	if($l->run())
		print $i . "\n";
	unset($); unset($l);
}

*/


/*
$l = new Lottery_AliasMethod(array(0.1, 0.2, 0.3, 0.4));
$gift = array();
for($i=0; $i<10000; $i++) {
	$idx = $l->luck();
	$gift[$idx] = isset($gift[$idx]) ? $gift[$idx]+1 : 1;
}
ksort($gift);
var_dump($gift);
*/
/* 比较理想
array(4) {
  [0] =>
  int(1066)
  [1] =>
  int(1977)
  [2] =>
  int(2965)
  [3] =>
  int(3992)
}
*/


/**/
$list = new Lottery_List(time(), strtotime("+1 day"), 1);
for($i=1; $i<11; $i++) {
	//其中$i/1000表示：单个奖品每个人抽中的概率. 则一个人抽中该类奖品(一类有多个奖品)的概率为=该类下的奖品总数*单个奖品的概率;
	//因为我们使用了渐变模型，不同模型最终中奖率不同。所以在设置中奖率时需要参考所选用的模型。如：reduce=1时，中奖率应该*2;
	$entity = new Lottery_Entity($i, "Lottery$i", $i, 2/1000);
	$list -> setEntity($entity);
	unset($entity);
}
$l = new Lottery_DynamicProbability($list);
$gift = array();
for($i=0; $i<30000; $i++) {
	Lottery_DynamicProbability::$time = time() + (3600*24*$i) / 30000;
	$idx = $l->luck();
	$gift[$idx]++;
}
ksort($gift);
var_dump($gift);
