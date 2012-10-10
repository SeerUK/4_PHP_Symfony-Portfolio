<?php

namespace SeerUK\Portfolio\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homeAction()
    {
    	$responseVariables = [
    		'pageTitle' => 'Home'
    	];
        return $this->render('SeerUKPortfolio:Home:home.html.twig', $responseVariables);
    }
}
