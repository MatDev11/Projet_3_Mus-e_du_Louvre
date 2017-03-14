<?php


namespace Ticketing\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class JourComplet extends Constraint
{
    public $message = "Le musée est complet, veuillez choisir un autre jour.";

    public function validatedBy()
    {
        return 'jour_complet';
    }
}

