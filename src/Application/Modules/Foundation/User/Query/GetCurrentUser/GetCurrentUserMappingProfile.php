<?php declare(strict_types=1);

namespace App\Application\Modules\Foundation\User\Query\GetCurrentUser;

use App\Application\Modules\Foundation\User\AbstractUserMappingProfile;
use App\Application\Modules\Foundation\User\Query\GetCurrentUser\Dto\UserDto;
use App\Application\Provider\Files\FileRender;
use App\Application\Provider\Reference\ReferenceAccessor;
use App\Domain\Model\Foundation\User\User;

/**
 * Class GetCurrentUserMappingProfile
 * @package App\Application\Modules\Foundation\User\Query\GetCurrentUser
 */
class GetCurrentUserMappingProfile extends AbstractUserMappingProfile
{
    /**
     * @var ReferenceAccessor
     */
    private $referenceAccessor;

    /**
     * @var FileRender
     */
    private $fileRender;

    /**
     * GetUsersMappingProfile constructor.
     * @param ReferenceAccessor $referenceAccessor
     * @param FileRender $fileRender
     */
    public function __construct(ReferenceAccessor $referenceAccessor, FileRender $fileRender)
    {
        parent::__construct();
        $this->referenceAccessor = $referenceAccessor;
        $this->fileRender = $fileRender;
    }

    /**
     * Mapping configuration
     */
    protected function initialize(): void
    {
        $this->config->registerMapping(User::class, UserDto::class)
            ->forMember("countryCodeValue", function (User $user) {
                return $this->referenceAccessor->getReference("country-code", $user->getCountryCode());
            })
            ->forMember("picture", function () {
                return $this->fileRender->getFile("hello-there.jpg");
            })
        ;
    }
}