<?php

namespace SeerUK\Portfolio\PortfolioBundle\Handlers\Feed;

use SeerUK\Portfolio\PortfolioBundle\Handlers\Datetime\DatetimeHandler;

class FeedHandler
{

	/**
	 * The final feed array (unsorted)
	 * @var array
	 */
	private $_feed = array();

	/**
	 * Adds a feed and parses it:
	 * @param [string] $parsewr [The feed parser type]
	 * @param [string] $source [The source for the parser to interpret]
	 */
	public function Add(ParseInterface $parser)
	{
		$feed = $parser->parse();
		$this->_feed = array_merge_recursive($this->_feed, $feed);
	}

	/**
	 * Returns the feed ready for placing in a webpage
	 * @param  [integer] $limit [If specified; limits the number of entires returned]
	 * @return [array]
	 */
	public function getFeed($limit = false)
	{
		$return = array();

		if(!empty($this->_feed))
		{
			$datetimeHandler = new DatetimeHandler;

			// Sort the array by time before returning...
			$this->sortFeed($this->_feed, 'timestamp');

			foreach($this->_feed as $entry)
			{
				$entry['timestamp'] = $datetimeHandler->getRelativeTime($entry['timestamp']);
				if($limit)
				{
					$return[] = $entry;
					$limit = $limit - 1;
					if($limit == 0)
					{
						break;
					}
				}
				else
				{
					$return[] = $entry;
				}
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
	public function sortFeed(&$feed, $column, $direction = SORT_DESC)
	{
		$sortColumn = array();

		foreach($feed as $key => $row)
		{
			$sortColumn[$key] = $row[$column];
		}

		$result = array_multisort($sortColumn, $direction, $feed);
	}

}