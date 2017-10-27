<?php

namespace AppBundle\Controller;

use Exception;
use AppBundle\Entity\Planeta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException as FRKE;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException as UnE;
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
        $form = $this->createForm('AppBundle\Form\PlanetaType', $planeta, [
            'form_submit' => 'insert'
        ]);
        $form->handleRequest($request);

        
        if ($form->isSubmitted())
        {
            if($form->isValid()) 
            {
                
                try
                {
                    $this->getDoctrine()->getRepository('AppBundle:Planeta')->insert($planeta);
                    $this->addFlash('success', "Nou planeta inserit: {$planeta->getNom()}");
                }
                catch(UnE $ex)
                {
                    $this->addFlash('error', "Error al inserir el planeta {$planeta->getNom()}: ja existeix un planeta amb aquest nom");
                    return $this->redirectToRoute('planeta_index');
                }
                
                return $this->redirectToRoute('planeta_show', [
                    'id' => $planeta->getId()
                ]);
            }
            else 
            {
                
                $validator = $this->get("validator");
                $errors = $validator->validate($planeta);

                foreach($errors as $error)
                {
                    $this->addFlash('error', $error->getMessage());
                }
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
    public function editAction(Request $request, Planeta $planeta)
    {
        $deleteForm = $this->createDeleteForm($planeta);
        $editForm = $this->createForm('AppBundle\Form\PlanetaType', $planeta, [
            'form_submit' => 'edit'
        ]);
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
            try
            {
                
                $this->getDoctrine()->getRepository('AppBundle:Planeta')->delete($planeta);

                $this->addFlash('success', "Planeta eliminat amb èxit: {$planeta->getNom()}");
            } 
            catch (FRKE $ex) 
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
}
