<?php

namespace SeerUK\Security\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class AccountController extends Controller
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

        return $this->render('SeerUKSecurityAccountBundle:Account:Login.html.twig',[
    		'pageTitle'     => 'Login',
    		'last_username' => $session->get(SecurityContext::LAST_USERNAME),
    		'error'         => $error,
    	]);
	}
}
