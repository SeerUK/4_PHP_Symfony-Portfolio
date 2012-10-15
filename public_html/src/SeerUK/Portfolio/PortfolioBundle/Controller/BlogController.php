<?php

namespace SeerUK\Portfolio\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SeerUK\Portfolio\PortfolioBundle\DependencyInjection\ExtendedController;

class BlogController extends ExtendedController
{
    public function homeAction()
    {
    	$responseVariables = [
    		'pageTitle' => 'Blog',
    	];
        return $this->render('SeerUKPortfolioBundle:Home:home.html.twig', $responseVariables);
    }
}
