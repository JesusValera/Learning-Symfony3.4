<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/football")
 */
class FootballControllerController extends Controller
{
    /**
     * @Route("/", name="foot_index")
     */
    public function indexAction()
    {
        return $this->render('football/index.html.twig');
    }

}
