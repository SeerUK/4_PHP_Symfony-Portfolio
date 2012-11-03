<?php

namespace SeerUK\Portfolio\PortfolioBundle\DependencyInjection\Cache;

use SeerUK\Portfolio\PortfolioBundle\DependencyInjection\Cache\CacheClientInterface;

class NullcacheClient implements CacheClientInterface
{
	/**
	 * Pseudo get method
	 */
	public function get($key){
		return false;
	}

	/**
	 * Pseudo set method
	 */
	public function set($key, $value, $duration)
	{
		return false;
	}
}