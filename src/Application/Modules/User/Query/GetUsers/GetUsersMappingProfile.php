<?php declare(strict_types=1);

namespace App\Application\Modules\User\Query\GetUsers;

use App\Application\Modules\User\AbstractUserMappingProfile;
use App\Application\Modules\User\Query\GetUsers\Dto\UserDto;
use App\Application\Provider\Reference\ReferenceAccessor;
use App\Domain\Model\User\User;

/**
 * Class GetUsersMappingProfile
 * @package App\Application\Modules\User\Query\GetUsers
 */
class GetUsersMappingProfile extends AbstractUserMappingProfile
{
    /**
     * @var ReferenceAccessor
     */
    private $referenceAccessor;

    /**
     * GetUsersMappingProfile constructor.
     * @param ReferenceAccessor $referenceAccessor
     */
    public function __construct(ReferenceAccessor $referenceAccessor)
    {
        parent::__construct();
        $this->referenceAccessor = $referenceAccessor;
    }

    /**
     * Mapping configuration
     */
    protected function initialize(): void
    {
        $this->config->registerMapping(User::class, UserDto::class)
            ->forMember("countryCodeValue", function (User $user) {
                return $this->referenceAccessor->getReference("country-code", $user->getCountryCode());
            });
    }
}