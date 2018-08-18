<?php

namespace TestAnnotationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TestAnnotationsBundle\Entity\Event;
use TestAnnotationsBundle\Form\EventsType;

class EventsController extends Controller
{
    /**
     * @Route("/events/all", name="all_events")
     */
    public function allAction()
    {
        // Get doctrine repository.
        $repository = $this->getDoctrine()->getRepository(Event::class);
        // Find all events from the repository.
        $events = $repository->findAll();

        return $this->render(
            'TestAnnotationsBundle:Event:all.html.twig',
            ["events" => $events]);
    }

    /**
     * @Route("/events/new", name="new_events")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newEventAction(Request $request)
    {
        $event = new Event();

        $form = $this->createForm(EventsType::class, $event);


        // 1. When initially loading the page, the form is created and rendered.
        // handleRequest() recognizes that the form was not submitted and does nothing.
        // isSubmitted() returns false if the form was not submitted.
        // ----
        // 2. When the user submits the form, handleRequest() recognizes this and
        // immediately writes the submitted data back into the $event object.
        // ----
        // 3. The submitted data is again written into the form.
        // Now you have the opportunity to perform some actions using
        // the returned object (e.g. persisting it to the database) before
        // redirecting the user to some other page (e.g. a "success" page).
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()
            && $form->get('agreeTerms')->getData()) {
            // $form->getData() holds the submitted values
            // but, the original `$event` variable has also been updated
            $event = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('all_events');
        }

        // The createView() method should be called after handleRequest().
        return $this->render(
            'TestAnnotationsBundle:Event:form.html.twig',
            ["form" => $form->createView()]);
    }


}
