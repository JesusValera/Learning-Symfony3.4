<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TestBundle:Default:index.html.twig');
    }

    public function nameAction($argum)
    {
        return $this->render('TestBundle:Default:name.html.twig', ['argum' => $argum]);
    }
}
