<?php

namespace TestAnnotationsBundle\Controller;

use TestAnnotationsBundle\Entity\Coach;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TestAnnotationsBundle\Form\CoachType;

/**
 * Coach controller.
 *
 * @Route("coach")
 */
class CoachController extends Controller
{
    /**
     * Lists all coach entities.
     *
     * @Route("/", name="coach_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $coaches = $em->getRepository(Coach::class)->findAll();

        return $this->render('TestAnnotationsBundle:Coach:index.html.twig', [
            'coaches' => $coaches,
        ]);
    }

    /**
     * Creates a new coach entity.
     *
     * @Route("/new", name="coach_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($coach);
            $em->flush();

            return $this->redirectToRoute('coach_show', ['id' => $coach->getId()]);
        }

        return $this->render('TestAnnotationsBundle:Coach:new.html.twig', [
            'coach' => $coach,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a coach entity.
     *
     * @Route("/{id}", name="coach_show")
     * @Method("GET")
     * @param Coach $coach
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Coach $coach)
    {
        $deleteForm = $this->createDeleteForm($coach);

        return $this->render('TestAnnotationsBundle:Coach:show.html.twig', [
            'coach'       => $coach,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing coach entity.
     *
     * @Route("/{id}/edit", name="coach_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Coach $coach
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Coach $coach)
    {
        $deleteForm = $this->createDeleteForm($coach);
        $editForm = $this->createForm(CoachType::class, $coach);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coach_edit', ['id' => $coach->getId()]);
        }

        return $this->render('TestAnnotationsBundle:Coach:edit.html.twig', [
            'coach'       => $coach,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a coach entity.
     *
     * @Route("/{id}", name="coach_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Coach $coach
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Coach $coach)
    {
        $form = $this->createDeleteForm($coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($coach);
            $em->flush();
        }

        return $this->redirectToRoute('coach_index');
    }

    /**
     * Creates a form to delete a coach entity.
     *
     * @param Coach $coach The coach entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Coach $coach)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('coach_delete', ['id' => $coach->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
