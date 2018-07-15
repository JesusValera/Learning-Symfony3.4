<?php

namespace TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('index.html.twig');
    }

    public function nameAction($nPila)
    {
        return $this->render('index.html.twig', ['nPila' => $nPila]);
    }
}
