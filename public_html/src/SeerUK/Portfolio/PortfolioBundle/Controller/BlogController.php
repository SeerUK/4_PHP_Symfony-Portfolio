<?php

namespace SeerUK\Portfolio\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use SeerUK\Portfolio\Controller\Module\Blog\HomeController;
use SeerUK\Portfolio\Controller\Module\Blog\ArticleController;

class BlogController extends Controller
{

    public function HomeAction()
    {
        $response = new Response;
        $response->setContent('<html><body><h1>Hello world!</h1></body></html>');
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

}
