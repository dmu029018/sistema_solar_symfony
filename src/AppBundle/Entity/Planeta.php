<?php

namespace AppBundle\Entity;

use AppBundle\CustomAbstraction\Entity as AppEntity;
use AppBundle\Entity\Satelit;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Planeta
 *
 * @ORM\Table(name="planeta", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_planeta_nom", columns={"nom"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlanetaRepository")
 */
class Planeta extends AppEntity
{
    /**
     * @var string
     *
     * @Assert\NotBlank(message="Nom ha de tenir un valor.")
     * @Assert\Length(min = 3, max = 20, minMessage="El nom d'un planeta ha de tenir entre 3 i 20 caràcters.", maxMessage="El nom d'un planeta ha de tenir entre 3 i 20 caràcters.")
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @var float
     *
     * @Assert\NotBlank(message = "La distància ha de tenir un valor.")
     * @Assert\Type(type="numeric", message = "La distància ha de tenir un valor numèric.")
     * @Assert\Range( min = 0 , minMessage = "La distància ha de tenir un valor positiu.")
     * @ORM\Column(name="distancia", type="float", precision=10, scale=0, nullable=false)
     */
    private $distancia;

    /**
     * @var float
     * 
     * @Assert\NotBlank(message="El període ha de tenir un valor.")
     * @Assert\Range( min = 0 , minMessage = "El període ha de tenir un valor positiu.")
     * @Assert\Type(type="numeric", message = "El període ha de tenir un valor numèric.")
     * @ORM\Column(name="periode", type="float", precision=10, scale=0, nullable=false)
     */
    private $periode;

    /**
     * @var float
     *
     * @Assert\NotBlank(message="El diàmetre ha de tenir un valor.")
     * @Assert\Type(type="numeric", message = "El diàmetre ha de tenir un valor numèric.")
     * @Assert\Range( min = 0 , minMessage = "El diàmetre ha de tenir un valor positiu.")
     * @ORM\Column(name="diametre", type="float", precision=10, scale=0, nullable=false)
     */
    private $diametre;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Escull una opció per a situació.")
     * @Assert\Choice(choices = {"I", "E"}, message = "Situació pot contenir només un dels següents valors: 'I', 'E'")
     * @ORM\Column(name="situacio", type="string", length=1, nullable=false)
     */
    private $situacio = 'E';

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Escull una opció per a tipus.")
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
        parent::__construct($params);
        $this->satelits = new ArrayCollection();
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
    
    public function getSatelits() {
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

    public function setSatelits($satelits) {
        $this->satelits = $satelits;
    }
    
}

