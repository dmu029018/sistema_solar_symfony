<?php

namespace AppBundle\CustomAbstraction;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entity
 *
 * @author alumne
 */
class Entity {
    
    public function __construct(array $params = [])
    {
        $this->updateParams($params);
    }
    
    /**
     * 
     * @param array $params Array clave-valor con parametros y valores
     */
    public function updateParams(array $params)
    {
        foreach($params as $k => $v)
        {
            $this->{"set" . ucfirst($k)}($v);
        }
    }
    
}
