<?php
/**
 * 奖品队列（当前广泛流行的奖品数据结构）
 * 通过队列来管理奖品。
 * @author yaunxch
 * @date 2015/4/13
 */
class Lottery_List extends ArrayIterator
{
	/**
	 * @var 数组中的位置
	 */
	private $position = 0;

	/**
	 * @var 奖品列表
	 */
	private $list = array();

	/**
	 * @var 奖品总量
	 */
	private $count = 0;

	/**
	 * @var 奖品类型数量
	 */
	private $length = 0;

	/**
	 * @var 抽奖开始时间
	 */
	private $begin = 0;

	/**
	 * @var 抽奖结束时间 
	 */
	private $stop = 0;


	public function __construct($begin, $stop)
	{
		$this->position = 0;

		if ($stop < $begin)
			throw new LotteryEngine_Exception("the stop time must be later than the begin time!");

		$this->begin = $begin;
		$this->stop = $stop;
	}

	
	public function rewind()
	{
		$this->position = 0;
	}

	public function current()
	{
		return $this->list[$this->position];
	}

	public function key()
	{
		return $this->position;
	}

	public function next()
	{
        ++$this->position;
    }

	public function valid()
	{
		return isset($this->list[$this->position]);
	}

	public function seek($position)
	{
		if ($position < 0 || $position > $this->length - 1) 
			return false;

		$this->position = $position;

		return $this->position;
	}

	/**
	 * 获取开始时间
	 * @return int
	 */
	public function getBegin()
	{
		return $this->begin;
	}

	/**
	 * 获取结束时间
	 * @return int
	 */
	public function getStop()
	{
		return $this->stop;
	}

	/**
	 * 奖品数量
	 * @return int
	 */
	public function count()
	{
		return $this->count;
	}

	/**
	 * 奖品分类数量
	 * @return int
	 */
	public function getLength()
	{
		return $this->length;
	}


	/**
	 * 添加奖品（已存在则更新）
	 * @param Entity $entity
	 */
	public function setEntity(Lottery_Entity $entity)
	{
		//添加奖品
		$this->list[] = $entity;

		//总量++
		$this->count += $entity->getCount();
		
		//总类++
		$this->length++;
	}
}