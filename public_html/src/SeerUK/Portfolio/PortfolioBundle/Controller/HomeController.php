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
        // Setup Feed:
        $feedHandler = new FeedHandler;
        $feedHandler->setCacheProvider(parent::getCacheProvider());

        $feedHandler->Add(new GithubParser('SeerUK'));
        $feedHandler->Add(new GithubParser('Unknown-Degree'));

        $feedContent = $this->render('SeerUKPortfolioBundle:Handlers:feed.html.twig', ['feed' => $feedHandler->getFeed(8)]);

        // Assign Page Variables:
        $responseVariables = [
            'pageTitle'      => 'Home',
            'recentActivity' => $feedContent->getContent()
        ];

        // Render Page:
        return $this->render('SeerUKPortfolioBundle:Home:home.html.twig', $responseVariables);
    }
}
