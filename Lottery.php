<?php
/**
 * 抽奖器接口 
 * @author yuanxch
 * @date 2015-4-10
 */
interface Lottery
{
	/**
	 * 运气，返回中奖id或幸运号
	 */
	public function luck();
}