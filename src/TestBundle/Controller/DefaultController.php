<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TestBundle:Default:index.html.twig');
    }

    public function indexRAction()
    {
        return $this->render('TestBundle:Default:index.html.twig');
    }

    public function nameAction($arg)
    {
        return $this->render('TestBundle:Default:name.html.twig', ['arg' => $arg]);
    }
}
