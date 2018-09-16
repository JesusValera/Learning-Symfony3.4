<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test")
 */
class TestController extends Controller
{
    /**
     * @Route("/", name="test_response")
     */
    public function responseAction()
    {
        return new Response("<body><h1>Testing response</h1><a><a href='/'>Homepage</a> </p></body>");
    }

    /**
     * @Route("/name/{arg}", name="test_args_twig")
     * @param string $arg
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nameAction($arg = 'Any argument.')
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

        return $this->render('test/name.html.twig', [
            "arg"   => $arg,
            "names" => $names,
        ]);
    }

    /**
     * @Route("/redirection", name="test_redirect")
     */
    public function redirectionAction()
    {
        //return $this->redirect($this->generateUrl('homepage'));
        return $this->redirectToRoute('homepage');
    }
}
