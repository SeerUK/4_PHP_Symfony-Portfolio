<?php

namespace SeerUK\Portfolio\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function defaultAction($page)
    {
        return $this->render('SeerUKPortfolio:Default:index.html.twig', [
            'page'   => strtolower($page)
        ]);
    }
}
