<?php declare(strict_types=1);

namespace App\Http\Exception\Normalizer;

use App\Core\Utils\Translator;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UniqueConstraintViolationExceptionNormalizer
 * @package App\Http\Exception\Normalizer
 */
class UniqueConstraintViolationExceptionNormalizer extends AbstractNormalizer
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * UniqueConstraintViolationExceptionNormalizer constructor.
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
        parent::__construct(UniqueConstraintViolationException::class, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @return string
     */
    function getMessage(): string
    {
        return $this->translator->trans("record_already_exists", [], Translator::DOMAIN_EXCEPTIONS);
    }
}