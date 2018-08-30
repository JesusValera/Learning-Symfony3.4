<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{

    /**
     * @return string
     * @Route("/", name="index_admin")
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig');
    }
}
