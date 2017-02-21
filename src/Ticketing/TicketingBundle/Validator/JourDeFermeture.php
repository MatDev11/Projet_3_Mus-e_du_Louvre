<?php


namespace Ticketing\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class JourDeFermeture extends Constraint
{
    public $message = "Il n'est pas possible de réserver pour ce jour";
}
