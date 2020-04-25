<?php declare(strict_types=1);

namespace App\Http\Middleware\EventListener;

use App\Core\Helper\LoggerHelper;
use App\Core\Utils\Translator;
use App\Domain\Exception\DomainException;
use App\Http\Exception\Normalizer\NormalizerInterface;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionListener
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var LoggerHelper
     */
    private $loggerHelper;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var NormalizerInterface[]
     */
    private $normalizers;

    /**
     * ExceptionListener constructor.
     * @param SerializerInterface $serializer
     * @param LoggerHelper $loggerHelper
     * @param Translator $translator
     */
    public function __construct(SerializerInterface $serializer, LoggerHelper $loggerHelper, Translator $translator)
    {
        $this->serializer = $serializer;
        $this->loggerHelper = $loggerHelper;
        $this->translator = $translator;
    }

    /**
     * @param ExceptionEvent $exceptionEvent
     * @throws \Exception
     * @throws \Throwable
     */
    public function processException(ExceptionEvent $exceptionEvent): void
    {

        if (!$this->translator->isContextAccessorInitialized()) {
            $this->translator->setLocale($exceptionEvent->getRequest()->getLocale());
        }
        $exception = $exceptionEvent->getThrowable();
        $this->loggerHelper->setTerminateEventBuffer($exception->getMessage());
        $message = null;
        if (in_array("getStatusCode", get_class_methods($exception))) {
            /** @var HttpException $exception */
            $statusCode = $exception->getStatusCode();
            $message = $this->getHttpExceptionMessage($exceptionEvent->getRequest(), $exception);
        } else {
            if (is_array($this->normalizers)) {
                foreach ($this->normalizers as $normalizerInterface) {
                    if ($normalizerInterface->supports($exception)) {
                        $statusCode = $normalizerInterface->getStatusCode();
                        $message = $normalizerInterface->getMessage();
                        $message .= $exception instanceof DomainException ? " - {$exception->getMessage()}" : "";
                        break;
                    }
                }
            }
        }

        if (!isset($statusCode)) {
            if ($_ENV["APP_ENV"] === "dev") {
                Debug::enable();
                throw $exception;
            } else {
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = $this->translator->trans("error_occured", [], Translator::DOMAIN_EXCEPTIONS);
            }
        }

        $exceptionEvent->setResponse(new Response(
            $this->serializer->serialize([
                "message" => $message,
                "error" => $this->loggerHelper->getUniqid()
            ], "json"),
            $statusCode
        ));
    }

    /**
     * @param NormalizerInterface $normalizer
     */
    public function addNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizers[] = $normalizer;
    }

    /**
     * @param Request $request
     * @param HttpException $exception
     * @throws \Exception
     * @return string
     */
    private function getHttpExceptionMessage(Request $request, HttpException $exception): string
    {
        switch ($statusCode = $exception->getStatusCode()) {
            case Response::HTTP_BAD_REQUEST :
                return $this->translator->trans("HTTP_BAD_REQUEST", [], Translator::DOMAIN_EXCEPTIONS);
                break;
            case Response::HTTP_FORBIDDEN :
                return $this->translator->trans("HTTP_FORBIDDEN", [],Translator::DOMAIN_EXCEPTIONS);
                break;
            case Response::HTTP_NOT_FOUND :
                return $this->translator->trans(
                    "HTTP_NOT_FOUND",
                    [
                        "verb" => $request->getMethod(),
                        "route" => $request->getRequestUri()
                    ],
                    Translator::DOMAIN_EXCEPTIONS
                );
                break;
            case Response::HTTP_METHOD_NOT_ALLOWED:
                return $this->translator->trans(
                    "HTTP_METHOD_NOT_ALLOWED",
                    [
                        "verb" => $request->getMethod(),
                        "route" => $request->getRequestUri(),
                        "verbs" => implode(", ", $exception->getPrevious()->getAllowedMethods())
                    ],
                    Translator::DOMAIN_EXCEPTIONS
                );
            case Response::HTTP_SERVICE_UNAVAILABLE:
                return $this->translator->trans("HTTP_SERVICE_UNAVAILABLE", [], Translator::DOMAIN_EXCEPTIONS);
            default:
                throw new \Exception(__CLASS__ . " - " . __FUNCTION__ . " - Unknown status code : $statusCode.");
                break;
        }
    }
}