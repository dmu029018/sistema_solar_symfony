<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManager;
use AppBundle\Repository\PlanetaRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SatelitType extends AbstractType
{
    
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $planets = $options['planet_repository']->findAll();
        
        $planets_array = [];
        
        foreach($planets as $planet)
        {
            $planetsArray[$planet->getNom()] = $planet->getId();
        }
        
        $builder->add('nom', TextType::class)
                ->add('idPlaneta', CollectionType::class,  [
                    'entry_type' => ChoiceType::class,
                    'choices' => $planets_array
                ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Satelit',
            'planet_repository' => "AppBundle\Entity\PlanetRepository"
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
