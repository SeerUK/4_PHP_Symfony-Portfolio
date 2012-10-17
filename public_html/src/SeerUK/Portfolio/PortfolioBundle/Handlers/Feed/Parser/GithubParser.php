<?php

	/**
	 * Github Feed Parser
	 *
	 * Parses Github feeds using the Github API (v3).
	 *
	 * @category SeerUK
	 * @package  3_PHP_New-Portfolio
	 * @version  0.1-alpha
	 * @since    0.1-alpha
	 *
	 */

	namespace SeerUK\Portfolio\PortfolioBundle\Handlers\Feed\Parser;

	use SeerUK\Portfolio\PortfolioBundle\Handlers\Feed\ParseInterface;

	class GithubParser implements ParseInterface
	{

		/**
		 * The current feed item when iterating over each item in the raw feed
		 * @var [object]
		 */
		private $_feedItem;

		/**
		 * The cache provider object for caching the current feed
		 * @var [object]
		 */
		private $_cacheProvider;

		/**
		 * The raw feed returned from the Github API in the form of a PHP array
		 * @var [array]
		 */
		private $_rawFeed;

		/**
		 * The user to parse the feed of
		 * @var [string]
		 */
		private $_username;

		/**
		 * Pass in Github username for feed to parse
		 * @param [string] $username [The user to parse the feed of]
		 * @todo  [Inject memcache dependancy better... connections shouldn't be made every time this class is instantiated]
		 */
		public function __construct($username)
		{
			$this->_username = $username;
		}

		/**
		 * Sets the cache provider
		 * @param \SeerUK\Portfolio\PortfolioBundle\DependencyInjection\CacheProvider $cacheProvider [A cache provider]
		 */
		public function setCacheProvider(\SeerUK\Portfolio\PortfolioBundle\DependencyInjection\Cache\CacheProvider $cacheProvider)
		{
			$this->_cacheProvider = $cacheProvider::getMemcache();
		}

		/**
		 * Returns the feed
		 * @return [array] [The raw feed]
		 */
		private function _getFeed()
		{
			$cachedFeed = $this->_cacheProvider->fetch(__CLASS__ . $this->_username);

			if(!empty($cachedFeed))
			{
				return $cachedFeed;
			}
			else
			{
				$response = $this->_getLiveFeed();

				if($this->_cacheProvider)
				{
					$this->_cacheProvider->save(__CLASS__ . $this->_username, $response, 300);
				}
				return $response;
			}
		}

		/**
		 * Makes a call to the Github API for the live feed (if not cached)
		 * @return [array] [A github feed array]
		 */
		private function _getLiveFeed()
		{
			$feedRoot = 'https://api.github.com';
			$feedUri  = '/users/' . $this->_username . '/events';

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, $feedRoot . $feedUri);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			$response = json_decode(curl_exec($curl));

			return $response;
		}

		/**
		 * Sets up the parsing of each event from the Github feed.
		 * @return [array] [The normalised feed ready for merging]
		 */
		public function parse()
		{
			$this->_rawFeed = $this->_getFeed();

			$returnedFeed = [ ];

			if(empty($this->_rawFeed))
			{
				return $returnedFeed;
			}

			$i = 0;
			foreach($this->_rawFeed as $feedItem)
			{
				$this->_feedItem = $feedItem;

				$returnedFeed[$i] = [
					'content'   => $this->_delegateEventHandler($feedItem),
					'timestamp' => strtotime($feedItem->created_at),
					'type'      => 'github',
					'owner'     => [
						'name' => $this->_username,
						'url'  => 'https://github.com/' . $this->_username
					]
				];

				$i++;
			}

			return $returnedFeed;
		}

		/**
		 * Delegates an event handler to handle all all of the Github payloads
		 * @param  [object] $feedItem [The current feed item]
		 */
		private function _delegateEventHandler()
		{
			$eventHandler = '_' . $this->_feedItem->type;

			if(method_exists($this, $eventHandler))
			{
				return $this->$eventHandler($this->_feedItem);
			}
			else
			{
				return $this->_DefaultEvent($this->_feedItem);
			}
		}

		private function _CommitCommentEvent()
		{
			return [
				'message' => 'commented on a commit in',
				'subject' => $this->_feedItem->repo->name,
				'url'     => $this->_feedItem->payload->comment->html_url
			];
		}

		private function _CreateEvent()
		{
			switch ($this->_feedItem->payload->ref_type)
			{
				case 'branch':
					$url = 'https://github.com/' . $this->_feedItem->repo->name . '/tree/' . $this->_feedItem->payload->ref;
					break;
				case 'repository':
				case 'tag':
				default:
					$url = 'https://github.com/' . $this->_feedItem->repo->name;
					break;
			}

			return [
				'message' => 'created a ' . $this->_feedItem->payload->ref_type,
				'subject' => $this->_feedItem->repo->name,
				'url'     => $url
			];
		}

		private function _DefaultEvent()
		{
			return [
				'message' => 'was active in',
				'subject' => $this->_feedItem->repo->name,
				'url'     => 'https://github.com/' . $this->_feedItem->repo->name . '/'
			];
		}

		private function _DeleteEvent()
		{
			return [
				'message' => 'deleted a ' . $this->_feedItem->payload->ref_type . ' in',
				'subject' => $this->_feedItem->repo->name,
				'url'     => $this->_feedItem->repo->name
			];
		}

		private function _DownloadEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _FollowEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _ForkEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _ForkApplyEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _GistEvent()
		{
			switch ($this->_feedItem->payload->action)
			{
				case 'create':
					$message = 'created ';
					break;
				case 'update':
					$message = 'updated ';
					break;
				default:
					$message = 'pursued ';
					break;
			}

			return [
				'message' => $message . 'gist',
				'subject' => $this->_feedItem->payload->gist->html_url,
				'url'     => $this->_feedItem->payload->gist->html_url
			];
		}

		private function _GollumEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _IssueCommentEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _IssuesEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _MemberEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _PublicEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _PullRequestEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _PullRequestReviewCommentEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _PushEvent()
		{
			return [
				'message' => 'pushed to ' . str_replace('refs/heads/', '', $this->_feedItem->payload->ref) . ' in',
				'subject' => $this->_feedItem->repo->name,
				'url'     => 'https://github.com/' . $this->_feedItem->repo->name . '/commit/' . $this->_feedItem->payload->commits[0]->sha
			];
		}

		private function _TeamAddEvent()
		{
			return $this->_DefaultEvent();
		}

		private function _WatchEvent()
		{
			return $this->_DefaultEvent();
		}


	}