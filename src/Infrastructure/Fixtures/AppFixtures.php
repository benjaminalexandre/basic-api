<?php

namespace App\Infrastructure\Fixtures;

use App\Domain\Model\Foundation\User\User;
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
        $user = new User("benjamin.alexandre", "MotDePasse71");
        $user->setName('Alexandre');
        $user->setFirstName('Benjamin');
        $user->setCountryCode('FRA');
        $user->setEmail("benjamin.alexandre@gmail.com");
        $user->setCellphone("0606060606");
        $manager->persist($user);

        $user = new User("john.doe", "MotDePasse22");
        $user->setName('Doe');
        $user->setFirstName('John');
        $user->setCountryCode('USA');
        $user->setEmail("john.doe@gmail.com");
        $user->setCellphone("0666666666");
        $manager->persist($user);

        $user = new User("sarahcroche", "All0L0la");
        $user->setName('Croche');
        $user->setFirstName('Sarah');
        $user->setCountryCode('FRA');
        $user->setEmail("sarahcroche@blaguedemerde.com");
        $manager->persist($user);

        $user = new User("xx_superKikouDu69_xx", "callOfDuty3TheBest");
        $user->setName('Dupont');
        $user->setFirstName('Kevin');
        $user->setCountryCode('FRA');
        $user->setEmail("kevdu42@skyblog.net");
        $manager->persist($user);

        $manager->flush();
    }
}
