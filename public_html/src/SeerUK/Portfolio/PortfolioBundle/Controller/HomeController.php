<?php

namespace SeerUK\Portfolio\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SeerUK\Portfolio\PortfolioBundle\DependencyInjection\ExtendedController;
use SeerUK\Portfolio\PortfolioBundle\Handlers\Feed\FeedHandler;
use SeerUK\Portfolio\PortfolioBundle\Handlers\Feed\Parser\GithubParser;

class HomeController extends ExtendedController
{
    public function homeAction()
    {
        $feedHandler = new FeedHandler;
        $feedHandler->Add(new GithubParser('SeerUK'));

        $feedContent = $this->render('SeerUKPortfolioBundle:Handlers:feed.html.twig', ['feed' => $feedHandler->getFeed(8)]);

        $responseVariables = [
            'pageTitle'      => 'Home',
            'recentActivity' => $feedContent->getContent()
        ];

        return $this->render('SeerUKPortfolioBundle:Home:home.html.twig', $responseVariables);
    }
}
