<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\Common;

use App\Domain\Model\Foundation\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait UserInsertTrait
{
    /**
     * @param KernelBrowser $client
     * @return User
     */
    public function insertUser(KernelBrowser $client): User
    {
        $user = new User();
        $user->setName("NAME");
        $user->setFirstName("FirstName");
        $user->setCountryCode("FRA");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine")->getManagerForClass(User::class);
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }
}