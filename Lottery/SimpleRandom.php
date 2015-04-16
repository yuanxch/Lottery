<?php

/**
 * 简单随机数(生成一个随机数，为中奖人的ID)
 * 适用那些简单的抽奖方式，如：N位员工，从0~N，程序随机生成一个数X，则编员为X的员工中奖。
 */
class Lottery_SimpleRandom implements Lottery
{
	/**
	 * @var 最小编号
	 */
	private $min = 0;
	/**
	 * @var 最大编号
	 */
	private $max = 0;

	/**
	 * 初始化
	 * @param int $min 最小号
	 * @param int $max 最大号
	 */
	public function __construct($min = 0, $max = 0)
	{
		if ($max < $min) {
			throw new LotteryEngine_Exception("the value of $max must be larger than $min's!");
		}

		$this->min = $min;
		$this->max = $max;
	}

	/**
	 * 幸运号
	 * @return int
	 */
	public function luck()
	{
		return mt_rand($this->min, $this->max);
	}
}
