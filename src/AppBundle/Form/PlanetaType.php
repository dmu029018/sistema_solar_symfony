<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class PlanetaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = []) 
    {
        $builder->add('nom', TextType::class, [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'constraints' => new Length([
                        'min' => 1,
                        'max' => 50
                            ])
                ])
                ->add('distancia', NumberType::class, [
                    'attr' => [
                        'class' => 'form-control',
                        'pattern' => '\d+(.\d+)?'
                    ],
                ])
                ->add('periode', NumberType::class, [
                    'attr' => [
                        'class' => 'form-control',
                        'pattern' => '\d+(.\d+)?'
                    ],
                ])
                ->add('diametre', NumberType::class, [
                    'attr' => [
                        'class' => 'form-control',
                        'pattern' => '\d+(.\d+)?'
                    ],
                ])
                ->add('situacio', ChoiceType::class, [
                    'choices'=>[
                        'Interior' => 'I', 
                        'Exterior' => 'E'
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'pattern' => 'I|E'
                    ],
                    'constraints' => new Length([
                        'min' => 1,
                        'max' => 1
                    ])
                ])
                ->add('tipus', ChoiceType::class, [
                    'choices'=>[
                        'Planeta' => 'P', 
                        'E' => 'E'
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'pattern' => 'P|E'
                    ],
                    'constraints' => new Length([
                        'min' => 1,
                        'max' => 1
                    ])
                ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Planeta'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_planeta';
    }

}
