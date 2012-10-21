<?php

namespace SeerUK\Portfolio\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use SeerUK\Portfolio\PortfolioBundle\DependencyInjection\ExtendedController;

class AccountController extends ExtendedController
{

	public function loginAction()
	{
		$request = $this->getRequest();
		$session = $request->getSession();

		if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
		{
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		}
		else
		{
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}

    	$responseVariables = [
    		'pageTitle' => 'Login',
    		'error'     => $error,
    	];
        return $this->render('SeerUKPortfolioBundle:Account:Login.html.twig', $responseVariables);
	}

}
