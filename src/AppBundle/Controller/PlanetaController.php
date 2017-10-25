<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Planeta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Planeta controller.
 *
 * @Route("/planeta")
 */
class PlanetaController extends Controller
{
    /**
     * Lists all planetum entities.
     *
     * @Route("/", name="planeta_index")
     * @Method("GET")
     */
    public function indexAction($notification = null)
    {
        $params = [
            'page_title' => "Llista de planetes",
            'planetas' => $this->getDoctrine()->getRepository('AppBundle:Planeta')->findAll(),
        ];
        
        if($notification)
        {
            $params['notification'] = $notification;
        }
        
        return $this->render('planeta/index.html.twig', $params);
    }

    /**
     * Creates a new planetum entity.
     *
     * @Route("/new", name="planeta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $planeta = new Planeta();
        $form = $this->createForm('AppBundle\Form\PlanetaType', $planeta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planeta);
            $em->flush();

            return $this->redirectToRoute('planeta_show', [
                'id' => $planeta->getId(),
                'notification' => "Nou planeta inserit: {$planeta->getNom()}",
            ]);
        }

        return $this->render('planeta/new.html.twig', array(
            'planeta' => $planeta,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a planetum entity.
     * 
     * CURIOSIDAD: Si le pasas un objeto como argumento a la acción(planeta),
     * pero le pasas al slug un argumento que sea una propiedad de dicho objeto, 
     * buscará el objeto que coincida. Para acciones de este tipo se aconseja que
     * se utilicen propiedades únicas. Esto nos permite buscar por nombre o por
     * id usando la misma ruta.
     *
     * @Route("/{id}", name="planeta_show", requirements={"id": "^\d+"})
     * @Route("/{nom}", name="planeta_show_by_name")
     * @Method({"GET", "POST"})
     */
    public function showAction(Planeta $planeta, $notification = null)
    {
        $deleteForm = $this->createDeleteForm($planeta);

        $satelits = $this->getDoctrine()->getRepository('AppBundle:Planeta')->getAllSatelits($planeta->getId());
        
        
        $params = [
            'planeta' => $planeta,
            'satelits' => $satelits,
            'delete_form' => $deleteForm->createView(),
        ];
        
        if($notification)
        {
            $params['notification'] = $notification;
        }
        
        return $this->render('planeta/show.html.twig', $params);
    }

    /**
     * @Route("/filter/{filter}/{val}", name="planeta_show_filter")
     */
    public function showWithFilterAction($filter, $val)
    {
        $planetes = [];
        $filter_name = "Planetes";
        
        switch($filter)
        {
            case "distancia_min":
                $planetes = $this->getDoctrine()->getRepository("AppBundle:Planeta")->selectByDistanciaMin($val);
                $filter_name = "Planetes amb una distància mínima de {$val}UA";
                break;
            case "distancia_max":
                $planetes = $this->getDoctrine()->getRepository("AppBundle:Planeta")->selectByDistanciaMax($val);
                $filter_name = "Planetes amb una distància màxima de {$val}UA";
                break;
        }
        
        return $this->render('planeta/index.html.twig', [
            'page_title' => $filter_name,
            'planetas' => $planetes,
        ]);
        
        
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

            return $this->redirectToRoute('planeta_edit', [
                'id' => $planetum->getId()
            ]);
        }

        return $this->render('planeta/edit.html.twig', array(
            'planeta' => $planetum,
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
