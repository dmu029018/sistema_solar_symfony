<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Planeta;

/**
 * Description of PlanetaRepository
 *
 * @author alumne
 */
class PlanetaRepository extends EntityRepository
{
    public function selectByDistanciaMin($distancia)
    {
        $query = $this->_em->createQueryBuilder()
                ->select('p')
                ->from('AppBundle:Planeta', 'p')
                ->where('p.distancia > :distancia')
                ->orderBy('p.distancia', 'ASC')
                ;
        
        $query->setParameter('distancia', $distancia);
        
        return $query->getQuery()->getResult();
    }

    public function selectByDistanciaMax($distancia)
    {
        $query = $this->_em->createQueryBuilder()
                ->select('p')
                ->from('AppBundle:Planeta', 'p')
                ->where('p.distancia < :distancia')
                ->orderBy('p.distancia', 'ASC')
                ;
        
        $query->setParameter('distancia', $distancia);
        
        return $query->getQuery()->getResult();
    }
    
    
    public function insert(Planeta $planeta)
    {
        $em = $this->_em;
        $em->persist($planeta);
        $em->flush();
    }
    
    public function addSatelit($id_planeta, $name)
    {
        
    }
    
    public function getAllSatelits($id)
    {
        
        return $this->_em
                ->getRepository('AppBundle:Satelit')
                ->findByIdPlaneta($id);
    }
    
    public function getData($id)
    {
    }
    
    public function editPlaneta($id)
    {
        
    }
    
    public function delete($id)
    {
        $em = $this->getEntityManager();
        
        $planeta = $this->find($id);
        
        $em->delete($planeta);
        $em->flush();
        
        return $planeta;
    }
    
}
