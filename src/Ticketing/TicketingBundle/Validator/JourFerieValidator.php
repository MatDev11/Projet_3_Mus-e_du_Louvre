<?php


namespace Ticketing\TicketingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class JourFerieValidator extends ConstraintValidator
{
    private $JourFerie  = ['01/05', '01/11', '25/12'];


    public function validate($value, Constraint $constraint) {
        $jourVisite = date('d/m', $value->getTimestamp());
        $JourFerie = $this->getJourFerie();

        foreach ($JourFerie as $JourFerie) {
            if ($jourVisite == $JourFerie) {
                // Déclenche l'erreur
                $this->context->addViolation($constraint->message);
            }
        }
    }

    public function getJourFerie() {
        return $this->JourFerie;
    }
}