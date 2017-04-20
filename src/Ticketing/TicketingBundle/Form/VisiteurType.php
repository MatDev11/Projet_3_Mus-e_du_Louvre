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


        $builder->add('nom', TextType::class, array(
            'label' => 'Nom*:'))
            ->add('prenom', TextType::class, array(
                'label' => 'Prénom*:'))
            ->add('pays', CountryType::class,
                array('label' => 'Pays*:',
                    'preferred_choices' => array(('FR'))
                ))
            ->add('dateDeNaissance', BirthdayType::class,
                array('label' => 'Date de naissance*:',
                    'format' => 'dd/MM/yyyy',
                    'attr' => array('class' => 'dateNaissance')
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
