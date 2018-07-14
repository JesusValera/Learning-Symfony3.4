<?php

namespace TestAnnotationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('TestAnnotationsBundle:Default:index.html.twig');
    }

    /**
     * @Route("/name")
     */
    public function nameAction()
    {
        return $this->render('TestAnnotationsBundle:Default:name.html.twig');
    }
}
