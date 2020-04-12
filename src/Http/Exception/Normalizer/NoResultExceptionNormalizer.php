<?php declare(strict_types=1);

namespace App\Http\Exception\Normalizer;

use App\Core\Utils\Translator;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NoResultExceptionNormalizer
 * @package App\Http\Exception\Normalizer
 */
class NoResultExceptionNormalizer extends AbstractNormalizer
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * NoResultExceptionNormalizer constructor.
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
        parent::__construct(NoResultException::class, Response::HTTP_NOT_FOUND);
    }

    /**
     * @return string
     */
    function getMessage(): string
    {
        return $this->translator->trans("no_results", [], Translator::DOMAIN_EXCEPTIONS);
    }
}