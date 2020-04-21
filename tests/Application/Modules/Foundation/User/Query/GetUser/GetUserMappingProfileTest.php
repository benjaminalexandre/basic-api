<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Foundation\User\Query\GetUser;

use App\Application\Modules\Foundation\User\Query\GetUser\Dto\UserDto;
use App\Application\Modules\Foundation\User\Query\GetUser\GetUserMappingProfile;
use App\Application\Provider\Reference\ReferenceAccessor;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Application\Modules\AbstractMappingProfileTest;
use DateTime;

/**
 * Class GetUserMappingProfileTest
 * @package App\Tests\Application\Modules\Foundation\User\Query\GetUser
 *
 * @group application
 * @group user
 * @group mapping
 * @group getUser
 */
class GetUserMappingProfileTest extends AbstractMappingProfileTest
{
    /**
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function testMapWorks(): void
    {
        $user = new User();
        $user->setId(1);
        $user->setName("NAME");
        $user->setFirstName("FirstName");
        $user->setCountryCode("FRA");
        $user->setUpdatedAt(new DateTime());

        $referenceAccessor = new ReferenceAccessor("en");
        $profile = new GetUserMappingProfile($referenceAccessor);
        /** @var UserDto $userDto */
        $userDto = $profile->getMapper()->map($user, UserDto::class);

        self::assertEquals($user->getId(), $userDto->getId());
        self::assertEquals($user->getName(), $userDto->getName());
        self::assertEquals($user->getFirstName(), $userDto->getFirstName());
        self::assertEquals($user->getCountryCode(), $userDto->getCountryCode());
        self::assertEquals($user->getUpdatedAt(), $userDto->getUpdatedAt());
    }
}