<?php

namespace SeerUK\Portfolio\PortfolioBundle\Twig\Extension;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class NavigationExtension extends \Twig_Extension
{
	/**
	 * Returns an array containing the Twig functions supplied by this extension
	 * @return array An array of functions
	 */
	public function getFunctions()
	{
		return [
			'primary_navigation' => new \Twig_Function_Method($this, 'primaryFunction'),
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
	public function primaryFunction()
	{
		return [
			'Home'      => 'SeerUK_Home',
			'Blog'      => 'SeerUK_BlogHome',
			'Skills'    => 'SeerUK_BlogHome',
			'Portfolio' => 'SeerUK_BlogHome',
			'Contact'   => 'SeerUK_BlogHome',
		];
	}

}