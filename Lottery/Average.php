<?php
/**
 * 平均分配又称为固定分配(人数，时间)－抽奖算法
 * 适用于明确指值谋一位置中奖，如：1000人，10个奖品，平均每100人一个奖品。指定100人中第N个人中奖（各100人中的N可以随机）。
 * @author yuanxch
 * @date 2015-4-10
 */
class Lottery_Average implements Lottery
{

	/**
	 * @var 奖品总量
	 */
	private $lotteryTotal = 0;

	/**
	 * @var 用户总量
	 */
	private $userTotal = 0;

	/**
	 * @var 当前用户
	 */
	private $userSequence = 0;
	
	/**
	 * 初始化
	 * @param int $prizes 奖品数量
	 * @param int $userTotal 用户总量
	 * @param int $userSequence 用户排列序号
	 */
	public function __construct($lotteryTotal = 0, $userTotal = 0, $userSequence = 0)
	{
		$this->lotteryTotal = $lotteryTotal;
		$this->userTotal	= $userTotal;
		$this->userSequence = $userSequence;
	}

	/**
	 * 抽奖
	 * @return boolean
	 */
	public function luck()
	{
		if ($this->userSequence > $this->userTotal) {
			throw new LotteryEngine_Exception("the lottery's position is overflow!");
		}

		$average = ceil($this->userTotal / $this->lotteryTotal);
		$mod = $this->userSequence % $average;
		
		return $mod == mt_rand(0, $average); 
	}
}