<?php

namespace SeerUK\Portfolio\PortfolioBundle\DependencyInjection\Cache;

class CacheProvider
{
	private static $memcacheProvider = null;

	/**
	 * Returns the memcache object
	 * @return [object] [A memcache object]
	 */
	public static function getMemcache()
	{
		if(!isset(self::$memcacheProvider)) {
			$host = 'localhost';
			$port = 11211;

			$memcache = new \Memcache();
			$memcache->addServer($host, $port);

			$stats     = @$memcache->getExtendedStats();
			$available = (bool) $stats["$host:$port"];

			$memcacheClient = new \Doctrine\Common\Cache\MemcacheCache();
			$memcacheClient->setMemcache($memcache);

			if (!$available || !@$memcache->connect($host, $port))
			{
				error_log(__METHOD__ . ": Memcache server not available at $host:$port");
			}

			self::$memcacheProvider = $memcacheClient;
		}

		return self::$memcacheProvider;
	}

}
