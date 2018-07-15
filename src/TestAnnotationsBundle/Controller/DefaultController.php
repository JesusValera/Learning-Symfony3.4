<?php

namespace TestAnnotationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="paco_index")
     */
    public function indexAction()
    {
        return $this->render('TestAnnotationsBundle:Default:index.html.twig');
    }

    /**
     * @Route("/name/{nPila}")
     */
    public function nameAction($nPila = 'Sin nombre')
    {
        return $this->render('TestAnnotationsBundle:Default:name.html.twig', ["nPila" => $nPila]);
    }

    /**
     * @Route("/example", name="paco_example")
     */
    public function exampleAction()
    {
        return $this->render('TestAnnotationsBundle:Default:example.html.twig');
    }

    /**
     * @Route("/redirection")
     */
    public function redirectionAction()
    {
        return $this->redirectToRoute('paco_index');
        //return $this->render('TestAnnotationsBundle:Default:redirection.html.twig');
    }
}
