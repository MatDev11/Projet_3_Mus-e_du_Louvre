<?php


namespace Ticketing\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class JourDeFermetureValidator extends ConstraintValidator
{
    private $jourDeFermeture = ['Sun', 'Tue'];

    // Prend en paramètre la date de réservation
    public function validate($value, Constraint $constraint)
    {
        $jourVisite = date('D', $value->getTimestamp());
        $jourDeFermeture = $this->getJourDeFermeture();

        foreach ($jourDeFermeture as $jourDeFermeture) {
            if ($jourVisite == $jourDeFermeture) {
                // Déclenche l'erreur
                $this->context->addViolation($constraint->message);
            }
        }
    }

    public function getJourDeFermeture()
    {
        return $this->jourDeFermeture;
    }
}