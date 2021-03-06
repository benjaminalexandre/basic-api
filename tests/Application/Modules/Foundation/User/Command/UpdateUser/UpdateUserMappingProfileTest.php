<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Foundation\User\Command\UpdateUser;

use App\Application\Modules\Foundation\User\Command\UpdateUser\Dto\UserDto;
use App\Application\Modules\Foundation\User\Command\UpdateUser\UpdateUserMappingProfile;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Application\Modules\AbstractMappingProfileTest;
use DateTime;

/**
 * Class UpdateUserMappingProfileTest
 * @package App\Tests\Application\Modules\Foundation\User\Command\UpdateUser
 *
 * @group application
 * @group user
 * @group mapping
 * @group updateUser
 */
class UpdateUserMappingProfileTest extends AbstractMappingProfileTest
{
    /**
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function testMapWorks(): void
    {
        /** @var User $user */
        $user = new User("login", "Passw0rd");
        $user->setName("OLD NAME");
        $user->setFirstName("Old FirstName");
        $user->setCountryCode("GBR");
        $user->setEmail("email");
        $user->setCellphone("0600000000");
        $user->setUpdatedAt(new DateTime("1970-01-01 00:00:00"));

        $userDto = new UserDto();
        $userDto->setName("NAME");
        $userDto->setFirstName("FirstName");
        $userDto->setCountryCode("FRA");
        $userDto->setCellphone("0606060606");
        $userDto->setUpdatedAt(new DateTime());

        /** @noinspection PhpParamsInspection */
        $profile = new UpdateUserMappingProfile();
        /** @var User $updatedUser */
        $updatedUser = $profile->getMapper()->mapToObject($userDto, $user);

        self::assertEquals($userDto->getName(), $updatedUser->getName());
        self::assertEquals($userDto->getFirstName(), $updatedUser->getFirstName());
        self::assertEquals($userDto->getCountryCode(), $updatedUser->getCountryCode());
        self::assertEquals($user->getEmail(), $updatedUser->getEmail());
        self::assertEquals($userDto->getCellphone(), $updatedUser->getCellphone());
        self::assertEquals($user->getUpdatedAt(), $updatedUser->getUpdatedAt());

    }
}