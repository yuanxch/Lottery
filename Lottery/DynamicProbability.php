<?php
/**
 * 动态概率－抽奖算法（随时间动态调整中奖率）
 * @author yuanxch
 * @date 2015-4-10
 */
class Lottery_DynamicProbability implements Lottery
{	
	/**
	 * @var 奖品列表
	 */
	private $lotteryList = null;

	/**
	 * @var 渐变:1线性,2平方
	 */
	private $reduceMode = 1;

	/* Allocate space for the probability and alias tables. */
	private $prob = array();
	private $alias = array();

	/**
	 * @var 当前时间
	 */
	public static $time = false;



	/**
	 * 活动奖品(奖品数1*概率1 + 奖品2*概率2 +...+ < 1.0)
	 * @param LotteryList $lotteryList 
	 * @param int $reduce 渐变
	 */
	public function __construct(Lottery_List $lotteryList, $reduceMode = 1.0)
	{
		$this->lotteryList	= $lotteryList;
		$this->reduceMode		= $reduceMode;
	}


	/**
	 * 动态
	 */
	public function dynamicReduce()
	{
		self::$time		= self::$time ? self::$time : time();		
		$probabilities	= array();
		$begin			= $this->lotteryList->getBegin();
		$expire			= $this->lotteryList->getStop();
		$factor			= (float)((self::$time - $begin) / ($expire - $begin));
		//$factor		= (float)(time() / $expire);
		//渐变:可以有很多中，如平方，线性，一元二次，等等。
		$reduce			= pow($factor, $this->reduceMode);	

		foreach ($this->lotteryList as $entity) {
			$probabilities[] = $entity->getProbability() * $entity->getCount() * ; 
		}
		
		//最后一个元素为不会中奖的概率
		$probabilities[]	= 1.0 - array_sum($probabilities);
		$average			= 1.0 / count($probabilities);

		//分组
		foreach ($probabilities as $idx => $probability) {
            /* If the probability is below the average probability, then we add
             * it to the small list; otherwise we add it to the large list.
             */
            if ($probability >= $average)
                $large[] = $idx;
            else
                $small[] = $idx;
        }


		while (!empty($small) && !empty($large)) {
            /* Get the index of the small and the large probabilities. */
            $less = array_pop($small);
            $more = array_pop($large);

            /* These probabilities have not yet been scaled up to be such that
             * 1/n is given weight 1.0.  We do this here instead.
			 * 所有概率在自己区间概率为：概率*总的区间;
             */
            $this->prob[$less] = $probabilities[$less] * count($probabilities);
            $this->alias[$less] = $more;

            /* Decrease the probability of the larger one by the appropriate
             * amount.
             */
            $probabilities[$more] = ($probabilities[$more] + $probabilities[$less]) - $average;

            /* If the new probability is less than the average, add it into the
             * small list; otherwise add it to the large list.
             */
            if ($probabilities[$more] >= 1.0 / count($probabilities))
                $large[] = $more;
            else
                $small[] = $more;
        }
		

		while (!empty($small))
            $this->prob[array_pop($small)] = 1.0;
        while (!empty($large))
            $this->prob[array_pop($large)] = 1.0;
	}



	/**
	 * 抽取奖品ID
	 * @return false | int
	 */
	public function luck()
	{	
		$this->dynamicReduce();

        /* Generate a fair die roll to determine which column to inspect. */
        $column = mt_rand(0, count($this->prob) - 1);

        /* Generate a biased coin toss to determine which option to pick. */
        $coinToss = mt_rand() / mt_getrandmax() < $this->prob[$column];

        /* Based on the outcome, return either the column or its alias. */
        $column = $coinToss ? $column : $this->alias[$column];
		
		if (false !== $this->lotteryList->seek($column)) {
			return $this->lotteryList->current()->getId();
		}

		return false;
	}
}