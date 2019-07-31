<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // client
        $userEntity = new Client();
        $userEntity->setLogin('Nick');
        $userEntity->setPassword('bar');
        $userEntity->setRoles(['ROLE_FOO']);
        $userEntity->setFirstName('Nick');
        $userEntity->setLastName('Johnson');
        $manager->persist($userEntity);
        $manager->flush();


    }
}
