<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Team;
use AppBundle\Form\TeamType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Team controller.
 *
 * @Route("team")
 */
class TeamController extends Controller
{
    /**
     * Lists all team entities.
     *
     * @Route("/", name="team_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository(Team::class)->findAll();

        return $this->render('team/index.html.twig', [
            'teams' => $teams,
        ]);
    }

    /**
     * Creates a new team entity.
     *
     * @Route("/new", name="team_new", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('team_show', ['id' => $team->getId()]);
        }

        return $this->render('team/new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a team entity.
     *
     * @Route("/{id}", name="team_show", methods={"GET"})
     * @param Team $team
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Team $team)
    {
        $deleteForm = $this->createDeleteForm($team);

        return $this->render('team/show.html.twig', [
            'team'        => $team,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing team entity.
     *
     * @Route("/{id}/edit", name="team_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Team $team
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Team $team)
    {
        $deleteForm = $this->createDeleteForm($team);
        $editForm = $this->createForm(TeamType::class, $team);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('team_edit', ['id' => $team->getId()]);
        }

        return $this->render('team/edit.html.twig', [
            'team'        => $team,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a team entity.
     *
     * @Route("/{id}", name="team_delete", methods={"DELETE"})
     * @param Request $request
     * @param Team $team
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Team $team)
    {
        $form = $this->createDeleteForm($team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($team);
            $em->flush();
        }

        return $this->redirectToRoute('team_index');
    }

    /**
     * Creates a form to delete a team entity.
     *
     * @param Team $team The team entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Team $team)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('team_delete', ['id' => $team->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
