<?php declare(strict_types=1);

namespace App\Application\Modules\Authentication\Authentication\Command\SignOut;

use App\Application\Common\Command\CommandHandlerInterface;
use App\Application\Common\Command\CommandInterface;
use App\Application\Common\Command\CommandResponseInterface;
use App\Application\Provider\Context\ContextAccessor;
use App\Domain\Model\Foundation\User\Repository\UserRepositoryInterface;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Class SignOutCommandHandler
 * @package App\Application\Modules\Authentication\Authentication\Command\SignOut
 */
class SignOutCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var ContextAccessor
     */
    private $contextAccessor;

    /**
     * @var CacheInterface
     */
    private $cacheAuthentication;

    /**
     * SignOutCommandHandler constructor.
     * @param UserRepositoryInterface $userRepository
     * @param ContextAccessor $contextAccessor
     * @param CacheInterface $cacheAuthentication
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        ContextAccessor $contextAccessor,
        CacheInterface $cacheAuthentication)
    {
        $this->userRepository = $userRepository;
        $this->contextAccessor = $contextAccessor;
        $this->cacheAuthentication = $cacheAuthentication;
    }

    /**
     * @param SignOutCommand $command
     * @return null
     */
    function handle(CommandInterface $command): ?CommandResponseInterface
    {
        $this->userRepository->getCurrentUser();
        $this->cacheAuthentication->delete($this->contextAccessor->getToken());
        return null;
    }
}