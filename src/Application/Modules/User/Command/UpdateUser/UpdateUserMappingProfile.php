<?php declare(strict_types=1);

namespace App\Application\Modules\User\Command\UpdateUser;

use App\Application\Modules\User\AbstractUserMappingProfile;
use App\Application\Modules\User\Command\UpdateUser\Dto\UserDto;
use App\Domain\Model\User\User;
use AutoMapperPlus\MappingOperation\Operation;

/**
 * Class UpdateUserMappingProfile
 * @package App\Application\Modules\User\Command\UpdateUser
 */
class UpdateUserMappingProfile extends AbstractUserMappingProfile
{
    /**
     * Mapping configuration
     */
    protected function initialize(): void
    {
        $this->config->registerMapping(UserDto::class, User::class)
            ->forMember("updatedAt", Operation::ignore());
    }
}