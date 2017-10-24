<?php

use Doctrine\ORM\EntityRepository;

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
    
    public function insert(array $data = [])
    {
        $em = $this->getEntityManager();
        
        $satelit = new Satelit($data);
        
        $em->persist($satelit);
        $em->flush();
        
        return $satelit;
    }
    
    public function delete($id)
    {
        $em = $this->getEntityManager();
        
        $satelit = $this->find($id);
        
        $em->delete($satelit);
        $em->flush();
        
        return $satelit;
    }
    
    
}
