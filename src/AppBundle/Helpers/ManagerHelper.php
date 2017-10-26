<?php

namespace AppBundle\Helpers;

use Doctrine\ORM\EntityManager;

/**
 * Description of ManagerHelper
 *
 * @author alumne
 */
class ManagerHelper 
{
    protected $manager;
    
    public function __construct(EntityManager $manager) {
        $this->manager = $manager;
    }
    
    public function getRepositories()
    {
       // $tasks = $this->manager->getRepository($entityName);
    }
}
