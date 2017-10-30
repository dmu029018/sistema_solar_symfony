<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\FormEvents;


class PlanetaType extends CosmicBodyType{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('distancia', NumberType::class, [
                'attr' => ['class' => 'form-control', 'pattern' => '\d+(.\d+)?'],
            ])
            ->add('periode', NumberType::class, [
                'attr' => ['class' => 'form-control', 'pattern' => '\d+(.\d+)?'],
            ])
            ->add('diametre', NumberType::class, [
                'attr' => ['class' => 'form-control','pattern' => '\d+(.\d+)?'],
            ])
            ->add('situacio', ChoiceType::class, [
                'expanded' => true, //Es una checkbox
                'choices'=> ['Interior' => 'I', 'Exterior' => 'E'],
                'choice_attr'=> ['Interior' => ['checked' => true]],
                'attr' => ['pattern' => 'I|E', 'class' => 'radio-group'],
                'constraints' => new Length(['min' => 1, 'max' => 1])
            ])
            ->add('tipus', ChoiceType::class, [
                'choices'=>['Planeta' => 'P', 'Planeta nan' => 'E'],
                'choice_attr' => ['Planeta' => ["selected" => true]],
                'attr' => ['class' => 'form-control','pattern' => 'P|E'],
                'constraints' => new Length(['min' => 1,'max' => 1])
            ]);
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'addDifferentFields']);
        
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Planeta',
            'validation_groups' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_planeta';
    }

    
}
