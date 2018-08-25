<?php

namespace TestAnnotationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
        return $this->render('TestAnnotationsBundle:Football:index.html.twig');
    }

}
