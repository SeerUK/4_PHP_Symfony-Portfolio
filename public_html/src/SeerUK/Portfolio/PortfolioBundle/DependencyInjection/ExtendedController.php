<?php

namespace SeerUK\Portfolio\PortfolioBundle\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SeerUK\Portfolio\PortfolioBundle\DependencyInjection\Cache\CacheProvider;

class ExtendedController extends Controller
{
	/**
	 * Returns the memcache object
	 * @return [object] [A memcache object]
	 */
	public static function getCacheProvider()
	{
		return new CacheProvider;
	}

}
