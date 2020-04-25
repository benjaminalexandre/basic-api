<?php declare(strict_types=1);

namespace App\Core\Utils;

use App\Application\Provider\Context\ContextAccessor;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class Translator
 * @package App\Core\Utils
 */
class Translator
{
    /**
     * @var string
     */
    const DOMAIN_EXCEPTIONS = "exceptions";
    const DOMAIN_VALIDATORS = "validators";

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var ContextAccessor
     */
    private $contextAccessor;

    /**
     * @var string
     */
    private $locale;

    /**
     * Translator constructor.
     * @param TranslatorInterface $translator
     * @param ContextAccessor $contextAccessor
     * @param string $locale
     */
    public function __construct(
        TranslatorInterface $translator,
        ContextAccessor $contextAccessor,
        string $locale
    )
    {
        $this->translator = $translator;
        $this->contextAccessor = $contextAccessor;
        $this->locale = $locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @return bool
     */
    public function isContextAccessorInitialized(): bool
    {
        return $this->contextAccessor->isInitialized();
    }

    /**
     * @param $id
     * @param array $parameters
     * @param null $domain
     * @return string
     */
    public function trans($id, array $parameters = [], $domain = null): string
    {
        return $this->translator->trans($id, $parameters, $domain, $this->locale);
    }
}