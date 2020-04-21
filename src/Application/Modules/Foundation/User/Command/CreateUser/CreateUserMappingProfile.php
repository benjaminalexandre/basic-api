<?php declare(strict_types=1);

namespace App\Application\Modules\Foundation\User\Command\CreateUser;

use App\Application\Modules\Foundation\User\AbstractUserMappingProfile;
use App\Application\Modules\Foundation\User\Command\CreateUser\Dto\UserDto;
use App\Domain\Model\Foundation\User\User;

/**
 * Class CreateUserMappingProfile
 * @package App\Application\Modules\Foundation\User\Command\CreateUser
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