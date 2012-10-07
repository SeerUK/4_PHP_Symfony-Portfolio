<?php

namespace SeerUK\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($module, $page)
    {
        return $this->render('SeerUKTestBundle:Default:index.html.twig', [
        	'page'   => strtolower($page),
        	'module' => strtolower($module)
		]);
    }
}
