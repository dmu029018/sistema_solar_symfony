<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PlanetaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => new Length(['min' => 1,'max' => 50]),
            
            ]);
        
        if($options['form_submit'] === 'insert')
        {
            $builder->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => new Length(['min' => 1,'max' => 50]),
            
            ]);
        }
        else if($options['form_submit'] === 'edit')
        {
            $builder->add('nom', HiddenType::class);
        }
        
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
        
        
        $submitAttr = [];
        
            if($options['form_submit'] === 'insert')
            {
                $submitAttr = [
                    'attr' => ['class' => 'btn btn-success'],
                    'label' => 'Inserir'
                ];
            }
            else if($options['form_submit'] === 'edit')
            {
                $submitAttr = [
                    'attr' => ['class' => 'btn btn-warning'],
                    'label' => 'Editar'
                ];
            }
            
            $builder->add("submit", SubmitType::class, $submitAttr);                
        
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Planeta',
            'form_submit' => 'insert'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_planeta';
    }

}
