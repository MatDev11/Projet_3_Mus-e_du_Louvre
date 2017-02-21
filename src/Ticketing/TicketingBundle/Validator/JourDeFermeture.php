<?php


namespace Ticketing\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class JourDeFermeture extends Constraint
{
    public $message2 = "Le musée est fermé, veuillez choisir un autre jour.";
}
