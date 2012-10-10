<?php

namespace SeerUK\Portfolio\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homeAction()
    {
    	$responseVariables = [
    		'pageTitle' => 'Home'
    	];
        return $this->render('SeerUKPortfolioBundle:Home:home.html.twig', $responseVariables);
    }
}
