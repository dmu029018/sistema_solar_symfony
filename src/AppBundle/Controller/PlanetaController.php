<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Planeta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Planetum controller.
 *
 * @Route("planeta")
 */
class PlanetaController extends Controller
{
    /**
     * Lists all planetum entities.
     *
     * @Route("/", name="planeta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $planetas = $em->getRepository('AppBundle:Planeta')->findAll();

        return $this->render('planeta/index.html.twig', array(
            'planetas' => $planetas,
        ));
    }

    /**
     * Creates a new planetum entity.
     *
     * @Route("/new", name="planeta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $planetum = new Planetum();
        $form = $this->createForm('AppBundle\Form\PlanetaType', $planetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planetum);
            $em->flush();

            return $this->redirectToRoute('planeta_show', array('id' => $planetum->getId()));
        }

        return $this->render('planeta/new.html.twig', array(
            'planetum' => $planetum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a planetum entity.
     *
     * @Route("/{id}", name="planeta_show")
     * @Method("GET")
     */
    public function showAction(Planeta $planetum)
    {
        $deleteForm = $this->createDeleteForm($planetum);

        return $this->render('planeta/show.html.twig', array(
            'planetum' => $planetum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing planetum entity.
     *
     * @Route("/{id}/edit", name="planeta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Planeta $planetum)
    {
        $deleteForm = $this->createDeleteForm($planetum);
        $editForm = $this->createForm('AppBundle\Form\PlanetaType', $planetum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planeta_edit', array('id' => $planetum->getId()));
        }

        return $this->render('planeta/edit.html.twig', array(
            'planetum' => $planetum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a planetum entity.
     *
     * @Route("/{id}", name="planeta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Planeta $planetum)
    {
        $form = $this->createDeleteForm($planetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planetum);
            $em->flush();
        }

        return $this->redirectToRoute('planeta_index');
    }

    /**
     * Creates a form to delete a planetum entity.
     *
     * @param Planeta $planetum The planetum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Planeta $planetum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('planeta_delete', array('id' => $planetum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
