<?php
/**
 * 随机－抽奖算法(参与人数已知)
 * 应用：$min~$max中间可以划分出多个奖品区间，利用“随机平均分布”来获得奖品。
 */
class Lotterye_RandomAlgorithm implements Lottery
{
	/**
	 *@var 奖品区间
	 */
	private $lotteryPrizeSequeue = array();

	/**
	 * @var 最小值
	 */
	private $min = 0;

	/**
	 * @var 最大值
	 */
	private $max = 0;

	
	/**
	 * 初始化
	 * @param array $lotteryPrizeSequeue 奖品列表
	 */
	public function __construct(LotteryPrizeSequeue $lotteryPrizeSequeue)
	{
		$this->lotteryPrizeSequeue = $lotteryPrizeSequeue;
	}

	/**
	 * 随机值下限
	 * @param int $min
	 */
	public function setRandomMin($min = 0)
	{
		$this->min = $min;
	}
	
	/**
	 * 随机值上限
	 * @param int $max
	 */
	public function setRandomMax($max = 0)
	{
		$this->max = $max;
	}


	/**
	 * 获得奖品
	 * @return int
	 */
	public function getPrize()
	{
		$digit = $this -> run();
		
		foreach ($this->lotteryPrizeSequeue as $prize) {
			if ($digit >= $prize->getScopeMin() && $digit <= $prize->getScopeMax()) {
				return $prize;
			}
		}
		
		return false;
	}


	/**
	 * 返回一个随机数
	 * @return int;
	 */
	public function run()
	{
		return mt_rand($this->lotteryPrizeSequeue->getScopeMin(), $this->lotteryPrizeSequeue->getScopeMax());
	}
}