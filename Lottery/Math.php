<?php

class Lottery_Math
{
	/**
	 * 最小公倍数定理：最小公倍数等于两数之积除以最大公约数。
	 * 最小公倍数（Least Common Multiple，缩写L.C.M.）
	 */
	public static function lcm($a, $b)
	{
		if(!(is_int($a) && $a > 0)) return $a;
		if(!(is_int($b) && $b > 0)) return $b;

		$gcd = self::gcd($a, $b);
		return ($a * $b)/$gcd;
	}

	/**
	 * 欧几里德算法：
	 * 欧几里德算法，用于计算两个正整数a，b的最大公约数。
	 * 定理：gcd(a,b) = gcd(b,a mod b) (a>b 且a mod b 不为0),gcd表示最大公约数
	 */
	public static function gcd($a, $b)
	{
		if(!(is_int($a) && $a > 0)) 
			throw new Exception('参数$a必须是正整数!');

		if(!(is_int($b) && $b > 0))
			throw new Exception('参数$b必须是正整数!');

		if ($a < $b) {
			  $t = $b;
			  $b = $a;
			  $a = $t;
		}

		$mod = $a % $b;		//取模运算，对应定理中的a mod b
		if ($mod === 0) 
			return $b;		//如果模为0，说明$b是最大公约数
		else				//否则，继续计算，这里用到了递归
			return self::gcd($b, $mod);
		   //这里对应定理中的gcd(b,a mod b)，可以看见，每一次递归，参数发生变化。第二次计算的参数1是上一次计算的参数2，第二次计算的参数2是上一次计算得到的模
	}
}