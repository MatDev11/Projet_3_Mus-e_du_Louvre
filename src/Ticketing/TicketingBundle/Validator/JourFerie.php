<?php


namespace Ticketing\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class JourFerie extends Constraint
{
    public $message = "Le musée est fermé, veuillez choisir un autre jour.";
}
