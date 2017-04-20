<?php

namespace Ticketing\TicketingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Ticketing\TicketingBundle\Validator\JourComplet;
use Ticketing\TicketingBundle\Validator\JourDeFermeture;
use Ticketing\TicketingBundle\Validator\JourFerie;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="Ticketing\TicketingBundle\Repository\commandeRepository")
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="num_commande", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $num_commande;

    /**
     * @var float
     *
     * @ORM\Column(name="prixTotal", type="float",nullable=true)
     *
     */
    private $prixTotal;

    /**
     * @var boolean
     *
     * @ORM\Column(name="type_tarif", type="boolean" , nullable=true)
     */
    private $type_tarif;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date_commande", type="datetime" , nullable=true)
     * @Assert\NotBlank()
     * @Assert\Range(
     *     min ="today",
     *     minMessage="Le jour est déjà passée !",
     * )
     * @JourDeFermeture()
     * @JourFerie()
     * @JourComplet()
     */
    private $date_commande;


    private $qtePlace;


    /**
     * @ORM\OneToMany(targetEntity="Ticketing\TicketingBundle\Entity\Visiteur", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $visiteurs;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        // Par défaut,  la date d'aujourd'hui
        $this->date_commande = new \Datetime();
        $this->visiteurs = new ArrayCollection();
        // Génère le numéro de commande
        $this->num_commande = uniqid();
    }

    /**
     * Set prixTotal
     *
     * @param float $prixTotal
     *
     * @return Commande
     */
    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    /**
     * Get prixTotal
     *
     * @return float
     */
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }


    /**
     * Set dateCommande
     *
     * @param \DateTime $date_commande
     *
     * @return Commande
     */
    public function setDateCommande($date_commande)
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    /**
     * Get dateCommande
     *
     * @return \DateTime
     */
    public function getDateCommande()
    {
        return $this->date_commande;
    }


    /**
     * Set typeTarif
     *
     * @param boolean $typeTarif
     *
     * @return Commande
     */
    public function setTypeTarif($typeTarif)
    {
        $this->type_tarif = $typeTarif;

        return $this;
    }

    /**
     * Get typeTarif
     *
     * @return boolean
     */
    public function getTypeTarif()
    {
        return $this->type_tarif;
    }


    /**
     * Add visiteur
     *
     * @param \Ticketing\TicketingBundle\Entity\Visiteur $visiteur
     * @deprecated
     *
     * @return Commande
     */
    public function addVisiteur(\Ticketing\TicketingBundle\Entity\Visiteur $visiteur)
    {
        $this->visiteurs[] = $visiteur;

        $visiteur->setCommande($this);

        return $this;
    }

    /**
     * Remove visiteur
     *
     * @param \Ticketing\TicketingBundle\Entity\Visiteur $visiteur
     */
    public function removeVisiteur(\Ticketing\TicketingBundle\Entity\Visiteur $visiteur)
    {
        $this->visiteurs->removeElement($visiteur);
    }

    /**
     * Get visiteurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVisiteurs()
    {
        return $this->visiteurs;
    }

    /**
     * Set numCommande
     *
     * @param string $numCommande
     *
     * @return Commande
     */
    public function setNumCommande($numCommande)
    {
        $this->num_commande = $numCommande;

        return $this;
    }

    /**
     * Get numCommande
     *
     * @return string
     */
    public function getNumCommande()
    {
        return $this->num_commande;
    }


    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {

        $date = new \DateTime('now');
        $date_commande = date('d/m/Y', $this->date_commande->getTimestamp());
        $heurDeVisite = date('H', $date->getTimestamp());
        $aujourdHui = date('d/m/Y', $date->getTimestamp());

        if ($this->type_tarif === false && $aujourdHui == $date_commande) {
            if ($heurDeVisite > 13) {
                $context->buildViolation('Une fois 14h passée vous devez prendre la demi journée.')
                    ->addViolation();
            }
        }

        if ($aujourdHui === $date_commande) {
            if ($heurDeVisite > 18) {
                $context->buildViolation('Le musée est fermé, veuillez choisir un autre jour. ')
                    ->addViolation();
            }
        }


    }


    /**
     * Set qtePlace
     *
     * @param float $qtePlace
     *
     * @return Commande
     */
    public function setQtePlace($qtePlace)
    {
        $this->qtePlace = $qtePlace;

        return $this;
    }

    /**
     * Get qtePlace
     *
     * @return float
     */
    public function getQtePlace()
    {
        return $this->qtePlace;
    }
}
