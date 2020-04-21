<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Foundation\User\Command\CreateUser;

use App\Application\Modules\Foundation\User\Command\CreateUser\CreateUserMappingProfile;
use App\Application\Modules\Foundation\User\Command\CreateUser\Dto\UserDto;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Application\Modules\AbstractMappingProfileTest;

/**
 * Class CreateUserMappingProfileTest
 * @package App\Tests\Application\Modules\Foundation\User\Command\CreateUser
 *
 * @group application
 * @group user
 * @group mapping
 * @group createUser
 */
class CreateUserMappingProfileTest extends AbstractMappingProfileTest
{
    /**
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function testMapWorks(): void
    {
        $userDto = new UserDto();
        $userDto->setName("NAME");
        $userDto->setFirstName("FirstName");
        $userDto->setCountryCode("FRA");

        /** @noinspection PhpParamsInspection */
        $profile = new CreateUserMappingProfile();
        /** @var User $user */
        $user = $profile->getMapper()->map($userDto, User::class);

        self::assertEquals($userDto->getName(), $user->getName());
        self::assertEquals($userDto->getFirstName(), $user->getFirstName());
        self::assertEquals($userDto->getCountryCode(), $user->getCountryCode());

    }
}