<?php


namespace Ticketing\TicketingBundle\Validator;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class JourCompletValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        $Jours = $this->em
            ->getRepository('TicketingBundle:Commande')
            ->myFindQte($value);


        if ($Jours > '1000') {
            // Déclenche l'erreur
            $this->context->addViolation($constraint->message);
        }
    }
}