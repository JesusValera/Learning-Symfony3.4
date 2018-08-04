<?php

namespace TestAnnotationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/annotations")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="anno_index")
     */
    public function indexAction()
    {
        return $this->render('TestAnnotationsBundle:Default:index.html.twig');
    }

    /**
     * @Route("/response", name="annoR_index")
     */
    public function indexRAction()
    {
        return new Response("<html><head><title>Response</title><body>Testing response.</body></head></html>");
    }

    /**
     * @Route("/name/{arg}", name="anno_name")
     * @param string $arg
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nameAction($arg = 'Any argument.')
    {
        if ($arg == 'error') {
            throw new NotFoundHttpException("ERROR");
        }
        return $this->render('TestAnnotationsBundle:Default:name.html.twig', ["arg" => $arg]);
    }

    /**
     * @Route("/example", name="anno_example")
     */
    public function exampleAction()
    {
        return $this->render('TestAnnotationsBundle:Default:example.html.twig');
    }

    /**
     * @Route("/redirection", name="anno_redirect")
     */
    public function redirectionAction()
    {
        //return $this->redirect($this->generateUrl('anno_index'));
        return $this->redirectToRoute('anno_index');
    }
}
