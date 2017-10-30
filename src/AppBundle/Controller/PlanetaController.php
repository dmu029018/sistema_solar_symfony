<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Planeta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


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
    public function indexAction()
    {
        $planetes = $this->getDoctrine()->getRepository('AppBundle:Planeta')->findAll();
        
        return $this->render('planeta/index.html.twig', [
            'page_title' => "Llista de planetes",
            'planetas' => $planetes,
        ]);
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
        
        if($form->isSubmitted() && $form->isValid()) 
        {
                
            if($this->getDoctrine()->getRepository('AppBundle:Planeta')->insert($planeta))
            {
                $this->addFlash('success', "Nou planeta inserit: {$planeta->getNom()}");

                return $this->redirectToRoute('planeta_show', [
                    'id' => $planeta->getId()
                ]);
            }
            else 
            {
                $this->addFlash('error', "Error al inserir el planeta {$planeta->getNom()}: ja existeix un planeta amb aquest nom");
                return $this->redirectToRoute('planeta_index');
            }
            
        }

        
        
        return $this->render('planeta/new.html.twig', [
            'planeta' => $planeta,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a planetum entity.
     * 
     * @Route("/{id}", name="planeta_show", requirements={"id": "^\d+"})
     * @Route("/{nom}", name="planeta_show_by_name")
     * @Method({"GET", "POST"})
     */
    public function showAction(Planeta $planeta)
    {
        if($planeta === null) 
        {
            $this->addFlash('error', "No s'ha trobat el planeta...");
            $this->redirectToRoute("planeta_index", 404);
        }

        $deleteForm = $this->createDeleteForm($planeta);

        $satelits = $this->getDoctrine()->getRepository('AppBundle:Planeta')->getAllSatelitsForAPlanet($planeta->getId());
        
        return $this->render('planeta/show.html.twig', [
            'planeta' => $planeta,
            'satelits' => $satelits,
            'delete_form' => $deleteForm->createView(),
        ]);
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
    public function editAction(Request $request, Planeta $planeta)
    {
        $deleteForm = $this->createDeleteForm($planeta);
        $editForm = $this->createForm('AppBundle\Form\PlanetaType', $planeta);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "Planeta {$planeta->getNom()} modificat amb èxit.");
            
            return $this->redirectToRoute('planeta_show', [
                'id' => $planeta->getId()
            ]);
        }

        return $this->render('planeta/edit.html.twig', array(
            'planeta' => $planeta,
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
    public function deleteAction(Request $request, Planeta $planeta)
    {
        $form = $this->createDeleteForm($planeta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            if($this->getDoctrine()->getRepository('AppBundle:Planeta')->delete($planeta))
            {
                $this->addFlash('success', "Planeta eliminat amb èxit: {$planeta->getNom()}");
            }
            else
            {
                $this->addFlash('error', "El planeta {$planeta->getNom()} no pot eliminar-se: Encara té satèl·lits associats");
            }
            
        }

        return $this->redirectToRoute('planeta_index');
    }

    /**
     * Crea un formulari per a esborrar una entitat de planeta de la base de dades.
     *
     * @param Planeta $planeta Entitat planeta
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Planeta $planeta)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('planeta_delete', array('id' => $planeta->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * PROVISIONAL
     * 
     * Create a pdf file for a planet.
     * 
     * @Route("/{id}/pdf", name="planeta_pdf", requirements={"id": "^\d+"})
     * @Route("/{nom}/pdf", name="planeta_pdf_by_name")
     * @Method({"GET", "POST"})
     */
    public function toPdfAction(Planeta $planeta) {
        if($planeta === null) 
        {
            $this->addFlash('error', "No s'ha trobat el planeta...");
            $this->redirectToRoute("planeta_index", 404);
        }

        $deleteForm = $this->createDeleteForm($planeta);

        $satelits = $this->getDoctrine()->getRepository('AppBundle:Planeta')->getAllSatelitsForAPlanet($planeta->getId());
        //TODO: Que funcione
        /*
        return new PdfResponse($this->get('knp_snappy.pdf')
                ->getOutputFromHtml($this->renderView("planeta/show.html.twig"))
                
                );
        */
        return $this->render('planeta/show.html.twig', [
            'planeta' => $planeta,
            'satelits' => $satelits,
            'delete_form' => $deleteForm->createView(),
        ]);
         
    }
}
