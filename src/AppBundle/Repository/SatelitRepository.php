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
        
        $success = true;
        
        try 
        {
            $em = $this->getEntityManager();

            $em->persist($satelit);
            $em->flush();
        
        }
        catch (Exception $ex) 
        {
            $success = false;
        }

        return $success;
        
    }
    
    public function delete(Satelit $satelit)
    {
        $success = true;
        
        try 
        {
            
            $em = $this->getEntityManager();

            $em->remove($satelit);
            $em->flush();
        
        }
        catch (Exception $ex) 
        {
            $success = false;
            
        }

        return $success;
    }
    
    
}
