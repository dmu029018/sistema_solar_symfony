<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\PlanetaEmbeddedType;


class SatelitType extends CosmicBodyType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('idPlaneta', EntityType::class,  [
                    'class' => 'AppBundle:Planeta',
                    'choice_label' => 'nom',
                    'label' => 'Planeta',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'placeholder' => 'Selecciona un planeta',
                    'required' => false
                ]);
        
        $builder->add('embeddedPlaneta', PlanetaEmbeddedType::class, [
            'required' => false
        ]);
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'addDifferentFields']);
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Satelit'
        ]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_satelit';
    }


}
