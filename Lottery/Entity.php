<?php

/**
 * 奖品实体
 */
class Lottery_Entity
{
	/**
	 * @var 奖品id
	 */
	private $id;

	/**
	 * @var 奖品名
	 */
	private $name;
	
	/**
	 * @var 奖品数量
	 */
	private $count;

	/**
	 * @var 命中其中一个奖品的概率
	 */
	private $probability;


	/**
	 * 初始化
	 * @param int $id
	 * @param string $name
	 * @param int $count
	 * @param float $probability 中奖概率概率
	 */
	public function __construct($id = 0, $name = '', $count = 0, $probability = 0.0)
	{
		$this->id = $id;
		$this->name = $name;
		$this->count = $count;
		$this->probability = $probability;
	}

	/**
	 * 获得奖品id
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * 获得奖品名称
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	
	/**
	 * 获得奖品数量
	 * @return int 
	 */
	public function getCount()
	{
		return $this->count;
	}
	
	/**
	 * 获得中奖概率百分比
	 * @return float
	 */
	public function getProbability()
	{
		return $this->probability;
	}
}