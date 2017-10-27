<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\Length;

class SatelitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $planets = $options['planetes'];
        
        $planets_array = [];
        
        foreach($planets as $planet)
        {
            $planets_array[$planet->getNom()] = $planet;
        }
        
        if($options['form_submit'] === 'insert')
        {
            $builder->add('nom', TextType::class, [
                'label' => 'Nom satèl·lit',
                'attr' => ['class' => 'form-control'],
                'constraints' => new Length(['min' => 1,'max' => 50]),
            
            ]);
        }
        else if($options['form_submit'] === 'edit')
        {
            $builder->add('nom', HiddenType::class);
        }
        
        
        $builder->add('idPlaneta', ChoiceType::class,  [
                   // 'entry_type' => ChoiceType::class,
                    'label' => 'Planeta',
                    'choices' => $planets_array,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]);
        
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
                    'attr' => ['class' => 'btn btn-warning btn-block'],
                    'label' => 'Editar'
                ];
            }
            
            $builder->add("submit", SubmitType::class, $submitAttr);                
        
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Satelit',
            'planetes' => [],
            'form_submit' => 'insert'
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
