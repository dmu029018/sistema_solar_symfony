<?php

namespace AppBundle\Entity;

use AppBundle\CustomAbstraction\Entity as AppEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Satelit
 *
 * @ORM\Table(name="satelit", 
 *      uniqueConstraints={
 *      @ORM\UniqueConstraint(
 *          name="UQ_satelit_nom", 
 *          columns={"nom"})
 *   }, 
 *      indexes={
 *          @ORM\Index(
 *              name="FK_planeta_satelit_01", 
 *              columns={"id_planeta"}
 *          )
 *      }
 *   )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SatelitRepository")
 * 
 */
class Satelit extends AppEntity
{
    /**
     * @var string
     *
     * 
     * @Assert\NotBlank(message="Nom ha de tenir un valor.")
     * @Assert\Length(
     *      min = 3, 
     *      max = 20, 
     *      minMessage="El nom d'un satèl·lit ha de tenir entre 3 i 20 caràcters.", 
     *      maxMessage="El nom d'un satèl·lit ha de tenir entre 3 i 20 caràcters.")
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
     * 
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_planeta", referencedColumnName="id")
     * })
     */
    private $idPlaneta;

    
    /**
     * @Assert\Type(type="AppBundle\Entity\Planeta")
     * @Assert\Valid()
     */
    protected $embeddedPlaneta;
    
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
    
    //
    
    function getEmbeddedPlaneta() {
        return $this->embeddedPlaneta;
    }

    function setEmbeddedPlaneta($embeddedPlaneta) {
        $this->embeddedPlaneta = $embeddedPlaneta;
    }



}

