<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Satelit
 *
 * @ORM\Table(name="satelit", uniqueConstraints={@ORM\UniqueConstraint(name="UQ_satelit_nom", columns={"nom"})}, indexes={@ORM\Index(name="FK_planeta_satelit_01", columns={"id_planeta"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SatelitRepository")
 * 
 */
class Satelit
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Planeta
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Planeta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_planeta", referencedColumnName="id")
     * })
     */
    private $idPlaneta;

    function getNom() {
        return $this->nom;
    }

    function getId() {
        return $this->id;
    }

    function getIdPlaneta(){
        return $this->idPlaneta;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdPlaneta($idPlaneta) {
        $this->idPlaneta = $idPlaneta;
    }


}

