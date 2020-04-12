<?php declare(strict_types=1);

namespace App\Http\Exception\Normalizer;

use App\Core\Utils\Translator;
use App\Domain\Exception\DomainException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DomainExceptionNormalizer
 * @package App\Http\Exception\Normalizer
 */
class DomainExceptionNormalizer extends AbstractNormalizer
{
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
        parent::__construct(DomainException::class, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @return string
     */
    function getMessage(): string
    {
        return $this->translator->trans("data_incorrect", [], Translator::DOMAIN_EXCEPTIONS);
    }
}