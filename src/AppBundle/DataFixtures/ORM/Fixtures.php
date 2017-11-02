<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use AppBundle\Entity\User;
/**
 * Description of Fixtures
 *
 * @author alumne
 */
class Fixtures extends Fixture
{
    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setUsername('pau');
        
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, '12345');
        $user->setPassword($password);
        
        $manager->persist($user);
        $manager->flush();
    }

}
