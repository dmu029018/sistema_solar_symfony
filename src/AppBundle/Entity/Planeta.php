<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Satelit;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Planeta
 *
 * @ORM\Table(name="planeta", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_planeta_nom", columns={"nom"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanetaRepository")
 */
class Planeta
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="distancia", type="float", precision=10, scale=0, nullable=false)
     */
    private $distancia;

    /**
     * @var float
     *
     * @ORM\Column(name="periode", type="float", precision=10, scale=0, nullable=false)
     */
    private $periode;

    /**
     * @var float
     *
     * @ORM\Column(name="diametre", type="float", precision=10, scale=0, nullable=false)
     */
    private $diametre;

    /**
     * @var string
     *
     * @ORM\Column(name="situacio", type="string", length=1, nullable=false)
     */
    private $situacio = 'E';

    /**
     * @var string
     *
     * @ORM\Column(name="tipus", type="string", length=1, nullable=false)
     */
    private $tipus = 'P';

    /**
     * @var float
     *
     * @ORM\Column(name="superficie", type="float", precision=10, scale=0, nullable=true)
     */
    private $superficie;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var array
     * 
     * @ORM\OneToMany(targetEntity="Satelit", mappedBy="Planeta")
     */
    protected $satelits;
    
    public function __construct()
    {
        $this->satelits = new ArrayCollection();
    }
    

    public function getNom() {
        return $this->nom;
    }

    public function getDistancia() {
        return $this->distancia;
    }

    public function getPeriode() {
        return $this->periode;
    }

    public function getDiametre() {
        return $this->diametre;
    }

    public function getSituacio() {
        return $this->situacio;
    }

    public function getTipus() {
        return $this->tipus;
    }

    public function getSuperficie() {
        return $this->superficie;
    }

    public function getId() {
        return $this->id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setDistancia($distancia) {
        $this->distancia = $distancia;
    }

    public function setPeriode($periode) {
        $this->periode = $periode;
    }

    public function setDiametre($diametre) {
        $this->diametre = $diametre;
    }

    public function setSituacio($situacio) {
        $this->situacio = $situacio;
    }

    public function setTipus($tipus) {
        $this->tipus = $tipus;
    }
    
    public function getSatelits()
    {
        
    }
    
}

