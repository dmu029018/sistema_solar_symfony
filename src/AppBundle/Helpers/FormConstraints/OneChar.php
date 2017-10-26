<?php

namespace AppBundle\Helpers\FormConstraints;

use Symfony\Component\Validator\Constraints\Length;

/**
 * Description of OneChar
 *
 * @author alumne
 */
class OneChar extends Length{
    
    public function __construct()
    {
        parent::__construct(["min"=> 1, "max"=> 1]);
    }
    
}
