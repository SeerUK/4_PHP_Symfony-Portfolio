<?php

namespace SeerUK\Portfolio\PortfolioBundle\Twig\Extension;

class NavigationExtension extends \Twig_Extension
{
	/**
	 * Returns an array containing the Twig functions supplied by this extension
	 * @return array An array of functions
	 */
	public function getFunctions()
	{
		return [
			'getPrimaryNavigation' => new \Twig_Function_Method($this, 'getPrimaryNavigation'),
		];
	}

	/**
	 * Provides the name for the Twig service in the service configurationp
	 * @return string The service name
	 */
	public function getName()
	{
		return 'navigation_extension';
	}

	/**
	 * Returns an array of the routes to show as primary navigation
	 * @return array An array of routes
	 */
	public function getPrimaryNavigation()
	{
		return [
			'Home'      => 'SeerUK_Home',
			'Blog'      => 'SeerUK_BlogHome',
			'Skills'    => 'SeerUK_BlogArticle',
			'Portfolio' => 'SeerUK_BlogArticle',
			'Contact'   => 'SeerUK_BlogArticle',
		];
	}

}