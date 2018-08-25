<?php

namespace TestAnnotationsBundle\Controller;

use TestAnnotationsBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use TestAnnotationsBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("category")
 *
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository(Category::class)->findAll();

        return $this->render('TestAnnotationsBundle:Category:index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/new", name="category_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_show', ['id' => $category->getId()]);
        }

        return $this->render('TestAnnotationsBundle:Category:new.html.twig', [
            'category' => $category,
            'form'     => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}", name="category_show")
     * @Method("GET")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('TestAnnotationsBundle:Category:show.html.twig', [
            'category'    => $category,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm(CategoryType::class, $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_edit', ['id' => $category->getId()]);
        }

        return $this->render('TestAnnotationsBundle:Category:edit.html.twig', [
            'category'    => $category,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}", name="category_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('category_index');
    }

    /**
     * Creates a form to delete a Category entity.
     *
     * @param Category $category The Category entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', ['id' => $category->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
