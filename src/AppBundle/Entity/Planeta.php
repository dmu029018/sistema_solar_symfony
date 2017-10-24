<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planeta
 *
 * @ORM\Table(name="planeta", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_planeta_nom", columns={"nom"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SatelitRepository")
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


    function getNom() {
        return $this->nom;
    }

    function getDistancia() {
        return $this->distancia;
    }

    function getPeriode() {
        return $this->periode;
    }

    function getDiametre() {
        return $this->diametre;
    }

    function getSituacio() {
        return $this->situacio;
    }

    function getTipus() {
        return $this->tipus;
    }

    function getSuperficie() {
        return $this->superficie;
    }

    function getId() {
        return $this->id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setDistancia($distancia) {
        $this->distancia = $distancia;
    }

    function setPeriode($periode) {
        $this->periode = $periode;
    }

    function setDiametre($diametre) {
        $this->diametre = $diametre;
    }

    function setSituacio($situacio) {
        $this->situacio = $situacio;
    }

    function setTipus($tipus) {
        $this->tipus = $tipus;
    }
    
}

