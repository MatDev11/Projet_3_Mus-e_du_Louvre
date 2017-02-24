<?php

namespace Ticketing\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class GroupeVisiteurType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)

    {


        for ($i = 0; $i < $options['nbBillet']; $i++) {


            $builder->add('visiteur' . $i, VisiteurType::class);


        }
        $builder ->add('submit', SubmitType::class);
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
