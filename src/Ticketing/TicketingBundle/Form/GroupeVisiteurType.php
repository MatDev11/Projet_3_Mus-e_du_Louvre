<?php

namespace Ticketing\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class GroupeVisiteurType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)

    {


        for ($i = 1; $i < $options['nbBillet'] + 1; $i++) {


            $builder->add('visiteur-' . $i, VisiteurType::class, array(
                'label' => '',
                'attr' => array('class' => 'col-lg-12')
            ));


        }

    }

    /**
     * @param OptionsResolver $resolver
     */

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(

            'nbBillet' => 'Ticketing\TicketingBundle\Entity\Visiteur'
        ));


    }


}
