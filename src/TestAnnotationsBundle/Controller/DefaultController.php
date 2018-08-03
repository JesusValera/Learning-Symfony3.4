<?php

namespace TestAnnotationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="anno_index")
     */
    public function indexAction()
    {
        //return $this->render('TestAnnotationsBundle:Events:all.html.twig');
        return $this->render('TestAnnotationsBundle:Default:index.html.twig');
    }

    /**
     * @Route("/{argum}", name="anno_name")
     * @param string $arg
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nameAction($argum = 'Any argument.')
    {
        return $this->render('TestAnnotationsBundle:Default:name.html.twig', ["argum" => $argum]);
    }

    /**
     * @Route("/example/", name="anno_example")
     */
    public function exampleAction()
    {
        return $this->render('TestAnnotationsBundle:Default:example.html.twig');
    }

    /**
     * @Route("/redirection/", name="anno_redirect")
     */
    public function redirectionAction()
    {
        return $this->redirectToRoute('anno_index');
        //return $this->render('TestAnnotationsBundle:Default:redirection.html.twig');
    }
}
