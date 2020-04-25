<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\Common;

use App\Domain\Model\Foundation\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait UserInsertTrait
{
    /**
     * @param KernelBrowser $client
     * @param null|string $login
     * @return User
     */
    public function insertUser(KernelBrowser $client, ?string $login = "login"): User
    {
        $user = new User($login, "Passw0rd");
        $user->setName("NAME");
        $user->setFirstName("FirstName");
        $user->setCountryCode("FRA");
        $user->setEmail("email");
        $user->setCellphone("0600000000");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $client->getContainer()->get("doctrine")->getManagerForClass(User::class);
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }
}