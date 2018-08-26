<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Event;
use AppBundle\Form\EventsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends Controller
{
    const NO_CONTENT = 'No content found.';
    const BAD_NAME_EVENT = 'There is no event with that name.';
    const BAD_NAME_EVENT_HELP = 'Check your typo name.';
    const NO_ALL_ELEMENTS = 'Missing elements.';

    /**
     * @Route("/events/all", name="all_events")
     */
    public function allAction()
    {
        // Get doctrine repository.
        $repository = $this->getDoctrine()->getRepository(Event::class);
        // Find all events from the repository.
        $events = $repository->findAll();

        return $this->render('event/all.html.twig', [
            "events" => $events,
        ]);
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
        return $this->render('event/form.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/events/new_category", name="new_event_and_category")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newEventCategoryAction()
    {
        // Category
        $category = new Category();
        $category->setName("Parties");

        // Event
        $event = new Event();
        $event->setName("Marathon 10k Barcelona");
        $event->setCity("Barcelona");
        $event->setDate(new \DateTime());
        $event->setPopulation("1.000");
        // Set $category into $event.
        $event->setCategory($category);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($category);
        $manager->persist($event);
        $manager->flush();

        return $this->redirectToRoute("all_events");
    }

    /**
     * @Route("/api/events/{name}", name="api_get", defaults={"name"="undefined"})
     * @Method({"GET"})
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apiGetAction($name = "undefined")
    {
        if ($name == "undefined") {
            return new JsonResponse($this->badRequest(self::BAD_NAME_EVENT, self::BAD_NAME_EVENT_HELP), 400);
        }

        $repository = $this->getDoctrine()->getRepository(Event::class);
        $event = $repository->findOneByName($name);

        if (!isset($event)) {
            return new JsonResponse($this->badRequest(self::NO_CONTENT, "Event not found"), 200);
        }

        $data['event'][] = $this->serializeEvent($event);

        return new JsonResponse($data, 200);
    }

    /**
     * @param string $msg
     * @param string|null $help
     * @return array
     */
    private function badRequest($msg, $help = null)
    {
        return ['message' => $msg, 'help' => $help];
    }

    /**
     * @Route("/api/events", name="api_post")
     * @Method({"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apiPostAction(Request $request)
    {
        // Check the Not_null values are all filled.
        if ($request->get('name') == null || $request->get('city') == null ||
            $request->get('population') == null) {

            return new JsonResponse($this->badRequest(self::NO_ALL_ELEMENTS, ""), 400);
        }

        $event = new Event();
        $event->setName($request->get('name'));
        $event->setCity($request->get('city'));
        $event->setPopulation($request->get('population'));
        $event->setDate(new \DateTime());

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($event);
        $manager->flush();

        // Return the created event.
        $data['event'][] = $this->serializeEvent($event);

        return new JsonResponse($data, 200);
    }

    private function serializeEvent(Event $event)
    {
        return [
            'name'     => $event->getName(),
            'city'     => $event->getCity(),
            'category' => $event->getCategory(),
            'date'     => $event->getDate(),
        ];
    }

}
