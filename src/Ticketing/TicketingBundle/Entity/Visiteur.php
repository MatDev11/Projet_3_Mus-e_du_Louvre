<?php

namespace Ticketing\TicketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Visiteur
 *
 * @ORM\Table(name="Visiteur")
 * @ORM\Entity(repositoryClass="Ticketing\TicketingBundle\Repository\visiteurRepository")
 */
class Visiteur
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
     * @ORM\Column(name="numSerie", type="string", length=255, nullable=true)
     */
    private $numSerie;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="Pays", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $pays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_de_naissance", type="datetime")
     */
    private $dateDeNaissance;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Reduction", type="boolean", length=255)
     */
    private $reduction;

    /**
     * @ORM\ManyToOne(targetEntity="Ticketing\TicketingBundle\Entity\Commande",inversedBy="visiteurs", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;



    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float",nullable=true)
     */
    private $prix;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Visiteur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Visiteur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Visiteur
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set dateDeNaissance
     *
     * @param \DateTime $dateDeNaissance
     *
     * @return Visiteur
     */
    public function setDateDeNaissance($dateDeNaissance)
    {
        $this->dateDeNaissance = $dateDeNaissance;

        return $this;
    }

    /**
     * Get dateDeNaissance
     *
     * @return \DateTime
     */
    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }





    /**
     * Set commande
     *
     * @param \Ticketing\TicketingBundle\Entity\commande $commande
     *
     * @return Visiteur
     */
    public function setCommande(\Ticketing\TicketingBundle\Entity\commande $commande)
    {
        $this->commande = $commande;
        //$commande->addVisiteur($this);

        return $this;
    }

    /**
     * Get commande
     *
     * @return \Ticketing\TicketingBundle\Entity\commande
     */
    public function getCommande()
    {
        return $this->commande;
    }


    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }


    public function getPrix()
    {
        return $this->prix;
    }


    /**
     * Set reduction
     *
     * @param boolean $reduction
     *
     * @return Visiteur
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;

        return $this;
    }

    /**
     * Get reduction
     *
     * @return boolean
     */
    public function getReduction()
    {
        return $this->reduction;
    }




    /**
     * Set numSerie
     *
     * @param string $numSerie
     *
     * @return Visiteur
     */
    public function setNumSerie($numSerie)
    {
        $this->numSerie = $numSerie;

        return $this;
    }

    /**
     * Get numSerie
     *
     * @return string
     */
    public function getNumSerie()
    {
        return $this->numSerie;
    }
}
