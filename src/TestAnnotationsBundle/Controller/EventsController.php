<?php

namespace TestAnnotationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TestAnnotationsBundle\Entity\Events;

class EventsController extends Controller
{
    /**
     * @Route("/events/all", name="all_events")
     */
    public function allAction()
    {
        // Get doctrine repository.
        $repository = $this->getDoctrine()->getRepository(Events::class);
        // Find all events from the repository.
        $events = $repository->findAll();

        return $this->render('TestAnnotationsBundle:Events:all.html.twig', ["events" => $events]);
    }
}
