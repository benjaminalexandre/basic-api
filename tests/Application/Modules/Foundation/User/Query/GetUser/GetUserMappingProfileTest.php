<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Foundation\User\Query\GetUser;

use App\Application\Modules\Foundation\User\Query\GetUser\Dto\UserDto;
use App\Application\Modules\Foundation\User\Query\GetUser\GetUserMappingProfile;
use App\Application\Provider\Context\ContextAccessor;
use App\Application\Provider\Files\FileRender;
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
        $user = new User("login", "Passw0rd");
        $user->setId(1);
        $user->setName("NAME");
        $user->setFirstName("FirstName");
        $user->setCountryCode("FRA");
        $user->setEmail("email");
        $user->setCellphone("0600000000");
        $user->setUpdatedAt(new DateTime());

        /** @noinspection PhpParamsInspection */
        $referenceAccessor = new ReferenceAccessor(self::createMock(ContextAccessor::class), "en");
        $fileRender = new FileRender();
        $profile = new GetUserMappingProfile($referenceAccessor, $fileRender);
        /** @var UserDto $userDto */
        $userDto = $profile->getMapper()->map($user, UserDto::class);

        self::assertEquals($user->getId(), $userDto->getId());
        self::assertEquals($user->getName(), $userDto->getName());
        self::assertEquals($user->getFirstName(), $userDto->getFirstName());
        self::assertEquals($user->getCountryCode(), $userDto->getCountryCode());
        self::assertEquals($user->getEmail(), $userDto->getEmail());
        self::assertEquals($user->getCellphone(), $userDto->getCellphone());
        self::assertEquals($user->getUpdatedAt(), $userDto->getUpdatedAt());
    }
}