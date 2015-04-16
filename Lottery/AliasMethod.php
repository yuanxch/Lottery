<?php
/**
 * 别名法(Alias method) 很适用于游戏中的“打怪获得礼品”, 筛子, 硬币等
 * @see http://www.keithschwarz.com/darts-dice-coins/
 * @author yuanxch
 * @date 2015/4/13
 */
class Lottery_AliasMethod implements Lottery
{

	/* Allocate space for the probability and alias tables. */
	private $prob = array();
	private $alias = array();

	/**
	 * 各礼品的概率(要求所有的概率之和必为1.0)
	 * @param array $probabilities = array("礼品ID" => 奖品概率);
	 */
	function __construct($probabilities = array())
	{
		//平均概率
		$average = 1.0 / count($probabilities);

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
	 * 获得奖品IDX
	 * @return int
	 */
	public function luck()
	{
        /* Generate a fair die roll to determine which column to inspect. */
        $column = mt_rand(0, count($this->prob) - 1);

        /* Generate a biased coin toss to determine which option to pick. */
        $coinToss = mt_rand() / mt_getrandmax() < $this->prob[$column];

        /* Based on the outcome, return either the column or its alias. */
        return $coinToss ? $column : $this->alias[$column];
	}
}