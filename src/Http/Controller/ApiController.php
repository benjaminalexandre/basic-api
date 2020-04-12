<?php declare(strict_types=1);

namespace App\Http\Controller;

use App\Application\Bus\RequestBusInterface;
use App\Application\Common\RequestResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ApiController
 * @package App\Http\Controller
 */
class ApiController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var RequestBusInterface
     */
    protected $bus;

    /**
     * AbstractController constructor.
     * @param SerializerInterface $serializer
     * @param RequestBusInterface $bus
     */
    public function __construct(SerializerInterface $serializer, RequestBusInterface $bus)
    {
        $this->serializer = $serializer;
        $this->bus = $bus;
    }

    /**
     * @param $content
     *
     * @return Response
     */
    protected function ok(RequestResponseInterface $content): Response
    {
        return $this->getResponse($content, 'json', Response::HTTP_OK);
    }

    /**
     * @param RequestResponseInterface $content
     *
     * @return Response
     */
    protected function created(RequestResponseInterface $content): Response
    {
        return $this->getResponse($content, 'json', Response::HTTP_CREATED);
    }

    /**
     * @return Response
     */
    protected function noContent(): Response
    {
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param RequestResponseInterface $content
     *
     * @return Response
     */
    protected function badRequest(RequestResponseInterface $content): Response
    {
        return $this->getResponse($content, 'json', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param RequestResponseInterface $content
     *
     * @return Response
     */
    protected function notFound(RequestResponseInterface $content): Response
    {
        return $this->getResponse($content, 'json', Response::HTTP_NOT_FOUND);
    }

    /**
     * @param RequestResponseInterface $content
     *
     * @param int $status
     * @return Response
     */
    protected function response(RequestResponseInterface $content, int $status = Response::HTTP_OK): Response
    {
        return $this->getResponse($content, 'json', $status);
    }

    /**
     * @param RequestResponseInterface $content
     * @param string $format
     * @param int $status
     *
     * @return JsonResponse
     */
    private function getResponse(RequestResponseInterface $content, string $format, int $status): JsonResponse
    {
        $response = $this->serializer->serialize($content, $format);
        return JsonResponse::fromJsonString($response, $status);
    }

}