<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Planeta;

/**
 * Description of PlanetaRepository
 *
 * @author David
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
    
    /**
     * Inserta un planeta a la base de dades.
     * @param Planeta $planeta
     * @return boolean True si la inserció del planeta s'ha realitzat amb èxit
     */
    public function insert(Planeta $planeta)
    {
        $success = true;
        
        try
        {
            $em = $this->_em;
            $em->persist($planeta);
            $em->flush();
        }
        catch(Exception $ex)
        {
            $success =  false;
        }
        
        return $success;
    }
    
    
    /**
     * Torna tots els satèl·lits que pertanyen a un planeta.
     * @param int $id
     * @return array 
     */
    public function getAllSatelitsForAPlanet($id)
    {
        return $this->_em
                ->getRepository('AppBundle:Satelit')
                ->findByIdPlaneta($id);
    }
    
    /**
     * Elimina un planeta de la base de dades
     * @param Planeta $planeta
     * @return boolean True Si la eliminació ha sigut exitosa
     */
    public function delete(Planeta $planeta)
    {
        $success = true;
        
        try
        {
            $em = $this->getEntityManager();

            $em->remove($planeta);
            $em->flush();
        } 
        catch (Exception $ex) 
        {
            $success = false;
        }
        
        return $success;
        
    }
    
}
