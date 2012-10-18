<?php

namespace SeerUK\Portfolio\PortfolioBundle\DependencyInjection\Cache;

use SeerUK\Portfolio\PortfolioBundle\DependencyInjection\Cache\CacheClientInterface;

class MemcacheClient implements CacheClientInterface
{
	/**
	 * The memcache object
	 * @var [object]
	 */
	private $_memcacheClient;

	/**
	 * Sets up the connection the given memcache server
	 * @param boolean $hostname [description]
	 * @param boolean $port     [description]
	 */
	public function __construct($hostname = false, $port = false)
	{
		$this->_connect($hostname, $port);
	}

	/**
	 * Returns the connected memcache object connected to the given connection
	 * information
	 * @return [object] [A memcache object]
	 */
	private function _connect($hostname, $port)
	{
		$host = !empty($hostname) ? $hostname : 'localhost';
		$port = !empty($port)     ? $port     : 11211;

		$memcache = new \Memcache();
		$memcache->addServer($host, $port);

		$stats     = @$memcache->getExtendedStats();
		$available = (bool) $stats["$host:$port"];

		if (!$available || !@$memcache->connect($host, $port))
		{
			error_log(__METHOD__ . ": Memcache server not available at $host:$port");
		}

		$this->_memcacheClient = $memcache;
	}

	/**
	 * Gets a cache entry by the given key(s)
	 * @param  [string|array] $key [A memcache storage key or an array of storage keys]
	 * @return [string|array]      [A string or an array of cache key(s) value(s)]
	 */
	public function get($key)
	{
		return $this->_memcacheClient->get($key);
	}

	/**
	 * Sets a cache entry by the given key, with the given value for the given duration
	 * @param [string]  $key      [A storage cache key]
	 * @param [unknown] $value    [A value to store]
	 * @param [integer] $duration [A duration before the cache expires]
	 */
	public function set($key, $value, $duration)
	{
		if(2592000 > $duration) {
			$duration = 2592000;
			error_log(__METHOD__ . ": Duration set to long. Setting cache expiration to maximum of 30 days.");
		}
		$this->_memcacheClient->set($key, $value, MEMCACHE_COMPRESSED, $duration);
	}
}
