<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\FormEvents;

abstract class CosmicBodyType extends AbstractType{

        /**
     * Afegeix al formulari els camps que difereixen segons si el formulari és d'inserció o d'edició
     */
    public function addDifferentFields(FormEvent $event)
    {
        $object = $event->getData();
        $form = $event->getForm();

        if(!$object || $object->getId() === null)
        {
            //Nuevo planeta. Eso implica que el campo name aparece
            $form->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => new Length(['min' => 1,'max' => 50]),
            ]);

            $submitAttr = ['attr' => ['class' => 'btn btn-success'], 'label' => 'Inserir'];
        }
        else
        {
            $submitAttr = ['attr' => ['class' => 'btn btn-warning'], 'label' => 'Editar'];
        }


        $form->add("submit", SubmitType::class, $submitAttr);  
    }

    

}