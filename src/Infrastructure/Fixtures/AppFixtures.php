<?php

namespace App\Infrastructure\Fixtures;

use App\Domain\Model\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class Fixtures
 * @package App\Infrastructure\Fixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Vaujambon');
        $user->setFirstName('Andy');
        $user->setCountryCode('FRA');
        $manager->persist($user);

        $user = new User();
        $user->setName('Croche');
        $user->setFirstName('Sarah');
        $user->setCountryCode('FRA');
        $manager->persist($user);

        $user = new User();
        $user->setName('Hus');
        $user->setFirstName('Anne');
        $user->setCountryCode('GBR');
        $manager->persist($user);

        $user = new User();
        $user->setName('Culé');
        $user->setFirstName('Roland');
        $user->setCountryCode('FRA');
        $manager->persist($user);

        $manager->flush();
    }
}
