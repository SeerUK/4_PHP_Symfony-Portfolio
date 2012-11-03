<?php

namespace SeerUK\Portfolio\PortfolioBundle\Handlers\Datetime;

class DatetimeHandler
{
	/**
	 * Converts Unix timestamps into a relative time (i.e. Facebook style.)
	 * @param  [integer] $timestamp [A unix timestamp to be converted]
	 * @return [string]
	 */
	public static function getRelativeTime($timestamp)
	{
		$timeDifference = time() - $timestamp;
		$timePeriods    = array('second', 'minute', 'hour', 'day', 'week','month', 'years', 'decade');
		$timeLengths    = array('60', '60', '24', '7', '4.35', '12', '10');

		if ($timeDifference > 0)
		{
			$timeSuffix = 'ago';
		}
		else
		{
			$timeDifference = -$timeDifference;
			$timeSuffix     = 'to go';
		}

		for($i = 0; $timeDifference >= $timeLengths[$i]; $i++)
		{
			$timeDifference/= $timeLengths[$i];
			$timeDifference = round($timeDifference);
		}

		if($timeDifference != 1) $timePeriods[$i].= 's';

		return $timeDifference . ' ' . $timePeriods[$i] . ' ' . $timeSuffix;
	}
}