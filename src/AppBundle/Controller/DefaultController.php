<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/response", name="response")
     */
    public function responseAction()
    {
        return new Response("<body><h1>Testing response</h1><a><a href='/'>Homepage</a> </p></body>");
    }

    /**
     * @Route("/name/{arg}", name="args_twig")
     * @param string $arg
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nameAction($arg = 'No argument provided.')
    {
        if ($arg == 'error') {
            throw new NotFoundHttpException("ERROR");
        }

        $names = [
            'Jesus' => [
                'name'   => 'Jesus',
                'active' => true,
            ],
            'Juan'  => [
                'name'   => 'Juan',
                'active' => false,
            ],
            'Jose'  => [
                'name'   => 'Jose',
                'active' => true,
            ],
        ];

        return $this->render('default/name.html.twig', [
            "arg"   => $arg,
            "names" => $names,
        ]);
    }

    /**
     * @Route("/redirection", name="redirection")
     */
    public function redirectionAction()
    {
        //return $this->redirect($this->generateUrl('homepage'));
        return $this->redirectToRoute('homepage');
    }
}
