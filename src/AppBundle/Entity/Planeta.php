<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Satelit;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @Assert\Length(min = 3, max = 20)
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     * @Assert\Range( min = 0 , minMessage = "La distància ha de ser un valor positiu.")
     * @ORM\Column(name="distancia", type="float", precision=10, scale=0, nullable=false)
     */
    private $distancia;

    /**
     * @var float
     * 
     * @Assert\NotBlank()
     * @Assert\Range( min = 0 , minMessage = "El període ha de ser un valor positiu.")
     * @ORM\Column(name="periode", type="float", precision=10, scale=0, nullable=false)
     */
    private $periode;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     * @Assert\Range( min = 0 , minMessage = "El diàmetre ha de ser un valor positiu.")
     * @ORM\Column(name="diametre", type="float", precision=10, scale=0, nullable=false)
     */
    private $diametre;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Choice(choices = {"I", "E"}, message = "Situació pot contenir només un dels següents valors: 'I', 'E'")
     * @ORM\Column(name="situacio", type="string", length=1, nullable=false)
     */
    private $situacio = 'E';

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Choice(choices = {"P", "E"}, message = "Tipus pot contenir només un dels següents valors: 'P', 'E'")
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
     * @ORM\OneToMany(targetEntity="Satelit", mappedBy="idPlaneta")
     */
    protected $satelits;
    
    public function __construct(array $params = [])
    {
        $this->updateParams($params);
        //$this->satelits = new ArrayCollection();
    }
    
    /**
     * 
     * @param array $params Array clave-valor con parametros y valores
     */
    public function updateParams(array $params)
    {
        foreach($params as $k => $v)
        {
            $this->{"set" . ucfirst($k)}($v);
        }
    }
    
    public function getId() 
    {
        return $this->id;
    }

    public function getNom() 
    {
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

    public function getSatelits()
    {
        return $this->satelits;
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
    
}

