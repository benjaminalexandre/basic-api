<?php declare(strict_types=1);

namespace App\Application\Modules\User\Command\CreateUser;

use App\Application\Modules\User\AbstractUserMappingProfile;
use App\Application\Modules\User\Command\CreateUser\Dto\UserDto;
use App\Application\Provider\Reference\ReferenceAccessor;
use App\Domain\Model\User\User;

/**
 * Class CreateUserMappingProfile
 * @package App\Application\Modules\User\Command\CreateUser
 */
class CreateUserMappingProfile extends AbstractUserMappingProfile
{
    /**
     * Mapping configuration
     */
    protected function initialize(): void
    {
        $this->config->registerMapping(UserDto::class, User::class);
    }
}