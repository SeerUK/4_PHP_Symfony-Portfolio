<?php

namespace SeerUK\Portfolio\PortfolioBundle\Handlers\Feed;

class FeedHandler
{

	/**
	 * The final feed array (unsorted)
	 * @var array
	 */
	private $_feed = array();

	/**
	 * Constructor loads the currently 'installed' feed parsers.
	 *
	 * @todo Try learn what the hell you do with __autoload properly...
	 */
	public function __construct()
	{
		if ( $handle = opendir( dirname(__FILE__) . '/Parser/' ) ) {
			$files = array();

			while ( false !== ( $entry = readdir( $handle ) ) )
			{
				if( preg_match( '/[^\s]+(\.(?i)(\.php))$/', $entry ) )
				{
					require_once( dirname(__FILE__) . '/Parser/' . $entry );
				}
			}
			closedir( $handle );
		}
	}

	/**
	 * Adds a feed and parses it:
	 * @param [string] $parsewr [The feed parser type]
	 * @param [string] $source [The source for the parser to interpret]
	 */
	public function Add( ParseInterface $parser )
	{
		$feed = $parser->parse();
		$this->_feed = array_merge_recursive( $this->_feed, $feed );
	}

	/**
	 * Returns the feed ready for placing in a webpage
	 * @param  [integer] $limit [If specified; limits the number of entires returned]
	 * @return [array]
	 */
	public function getFeed( $limit = false )
	{
		$full   = array();
		$return = array();

		/* Build the full list of all feed entries.
		======================================== */
		foreach( $this->_feed as $entry )
		{
			$full[] = $entry;
		}

		/* Sort the array by time before returning...
		========================================== */
		$this->sortFeed( $full, 'timestamp' );

		foreach( $full as $entry )
		{
			//$entry['timestamp'] = Common::relativeTime( $entry['timestamp'] );
			if( $limit )
			{
				$return[] = $entry;
				$limit = $limit - 1;
				if( $limit == 0 )
				{
					break;
				}
			}
			else
			{
				$return[] = $entry;
			}
		}

		return $return;
	}

	/**
	 * Sorts the feeds multidimensional array so that all of the feeds
	 * can be sorted by time.
	 * @param [array]  $feed      [The feed array]
	 * @param [string] $column    [The key to sort by in the feed array]
	 * @param [string] $direction [(Optional) Sorting direction]
	 */
	public function sortFeed( &$feed, $column, $direction = SORT_DESC )
	{
		$sortColumn = array();

		foreach( $feed as $key => $row )
		{
			$sortColumn[$key] = $row[$column];
		}

		$result = array_multisort( $sortColumn, $direction, $feed);
	}

}