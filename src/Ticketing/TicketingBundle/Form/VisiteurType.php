<?php

namespace Ticketing\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class VisiteurType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)

    {


        $builder->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('pays', CountryType::class,
                array('preferred_choices' => array(('FR'))
                ))
            ->add('dateDeNaissance', BirthdayType::class,
                array('format' => 'dd/MM/yyyy'
                ))
            ->add('reduction', CheckboxType::class, array(
                'label' => 'Tarif reduit:',

                'required' => false,));

    }

    /**
     * @param OptionsResolver $resolver
     */

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ticketing\TicketingBundle\Entity\Visiteur',

        ));
    }


}
