<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Satelit;
/**
 * Description of SatelitRepository
 *
 * @author alumne
 */
class SatelitRepository extends EntityRepository
{
    
    public function findByIdPlaneta($id)
    {
        return $this->findBy(['idPlaneta'=>$id]);
    }
    
    public function insert(Satelit $satelit)
    {
        $em = $this->getEntityManager();
        $em->persist($satelit);
        $em->flush();
        
        return $satelit;
    }
    
    public function delete(Satelit $satelit)
    {
        $em = $this->getEntityManager();
        
        $em->remove($satelit);
        $em->flush();
        
        return $satelit;
    }
    
    
}
