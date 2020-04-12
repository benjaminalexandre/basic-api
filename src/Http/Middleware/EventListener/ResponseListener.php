<?php declare(strict_types=1);

namespace App\Http\Middleware\EventListener;

use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Class ResponseListener
 * @package App\Http\Middleware\EventListener
 */
class ResponseListener
{
    /**
     * @param ResponseEvent $responseEvent
     * @throws NoResultException
     */
    public function onKernelResponse(ResponseEvent $responseEvent): void
    {
        // Get requests returning 204 are in facts 404
        if ($responseEvent->getRequest()->isMethod(Request::METHOD_GET) &&
            $responseEvent->getResponse()->getStatusCode() == Response::HTTP_NO_CONTENT) {
            throw new NoResultException();
        }
    }
}