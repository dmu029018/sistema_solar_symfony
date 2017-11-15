<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Satelit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException as UnE;

/**
 * Satelit controller.
 *
 * @Route("/satelit")
 */
class SatelitController extends Controller
{
    /**
     * Lists all satelit entities.
     *
     * @Route("/", name="satelit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $satelits= $this->getDoctrine()->getManager()->getRepository('AppBundle:Satelit')->findAll();

        return $this->render('satelit/index.html.twig', array(
            'satelits' => $satelits,
        ));
    }

    /**
     * Creates a new satelit entity.
     *
     * @Route("/new", name="satelit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $satelit = new Satelit();
        $em = $this->getDoctrine()->getManager();
     
        $form = $this->createForm('AppBundle\Form\SatelitType', $satelit);
        
        $form->handleRequest($request);

        if ($form->isSubmitted()) 
        {
            $data = $form->getData();
          
            $validator = $this->get('validator');
            
            try
            {
                if($data->getIdPlaneta() === null) 
                {
                    $planetarepo = $em->getRepository('AppBundle:Planeta');
                    $planeta = $data->getEmbeddedPlaneta();
                    
                    $errors = $validator->validate($planeta);
                    
                    if(!count($errors))
                    {
                        $planetarepo->insert($planeta);
                        $data->setIdPlaneta($planetarepo->findOneByNom($planeta->getNom()));
                        
                        $this->addFlash('success', "Nou planeta afegit amb èxit: {$planeta->getNom()}");
                    }
                    else
                    {
                        foreach($errors as $error)
                        {
                            $this->addFlash('error', $error->getMessage());
                        }
                        
                        return $this->render('satelit/new.html.twig', array(
                            'satelit' => $satelit,
                            'form' => $form->createView(),
                        ));
                    }
                }
                
                $em->getRepository('AppBundle:Satelit')->insert($data);
                $this->addFlash('success', "Satèl·lit afegit amb èxit: {$data->getNom()}");
                
            }catch(UnE $ex)
            {
                $this->addFlash('error', "Error al inserir el satèl·lit {$satelit->getNom()}: ja existeix un satèl·lit amb aquest nom");
                    return $this->redirectToRoute('satelit_index');
            }
            return $this->redirectToRoute('satelit_show', [
                'id' => $satelit->getId(),
            ]);
        }

        return $this->render('satelit/new.html.twig', array(
            'satelit' => $satelit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a satelit entity.
     *
     * @Route("/{id}", name="satelit_show", requirements={"id": "^\d+"})
     * @Route("/{nom}", name="satelit_show_by_name")
     * 
     * @Method("GET")
     */
    public function showAction(Satelit $satelit)
    {
        $deleteForm = $this->createDeleteForm($satelit);

        return $this->render('satelit/show.html.twig', array(
            'satelit' => $satelit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing satelit entity.
     *
     * @Route("/{id}/edit", name="satelit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Satelit $satelit)
    {
        $deleteForm = $this->createDeleteForm($satelit);
        
        $planetes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Planeta')->findAll();
        
        $editForm = $this->createForm('AppBundle\Form\SatelitType', $satelit);
        
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            $this->addFlash('success', "El satèl·lit {$satelit->getNom()} ha sigut reassignat al planeta {$satelit->getIdPlaneta()->getNom()}");
            return $this->redirectToRoute('satelit_edit', array('id' => $satelit->getId()));
        }

        return $this->render('satelit/edit.html.twig', array(
            'satelit' => $satelit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a satelit entity.
     *
     * @Route("/{id}", name="satelit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Satelit $satelit)
    {
        $form = $this->createDeleteForm($satelit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $this->getDoctrine()->getRepository('AppBundle:Satelit')->delete($satelit);
            $this->addFlash('success', "Satèl·lit eliminat amb èxit: {$satelit->getNom()}");
            
        }

        return $this->redirectToRoute('satelit_index');
    }

    
    
    /**
     * Creates a form to delete a satelit entity.
     *
     * @param Satelit $satelit The satelit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Satelit $satelit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('satelit_delete', array('id' => $satelit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
