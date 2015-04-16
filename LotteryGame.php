<?php
/**
 * 抽奖
 * @author yuanxch
 * @date 2015-04-10 
 */

class LotteryGame
{
	
	private $lottery = null;

	/**
	 * 算法
	 */
	function __construct(Lottery $lottery)
	{
		$this->lottery = $lottery;
	}
	
	function luck()
	{
		return $this->lottery->luck();
	}
}