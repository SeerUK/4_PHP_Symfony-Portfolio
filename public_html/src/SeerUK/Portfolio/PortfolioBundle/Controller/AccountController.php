<?php

namespace SeerUK\Portfolio\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SeerUK\Portfolio\PortfolioBundle\DependencyInjection\ExtendedController;

class AccountController extends ExtendedController
{

	public function loginAction()
	{
    	$responseVariables = [
    		'pageTitle' => 'Login',
    	];
        return $this->render('SeerUKPortfolioBundle:Account:Login.html.twig', $responseVariables);
	}

}
