<?php

namespace SeerUK\Portfolio\PortfolioBundle\DependencyInjection\Cache;

interface CacheClientInterface
{
	public function get($key);
	public function set($key, $value, $duration);
}