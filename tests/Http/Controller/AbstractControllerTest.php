<?php declare(strict_types=1);

namespace App\Tests\Http\Controller;

use App\Application\Bus\RequestBusInterface;
use App\Application\Common\Command\CommandInterface;
use App\Application\Common\RequestInterface;
use App\Application\Provider\Authentication\AuthenticationProvider;
use App\Application\Provider\Authentication\UserTokenWrapper;
use App\Core\Utils\Extractor;
use App\Domain\Exception\DomainException;
use App\Http\Middleware\EventListener\Jwt\JwtAuthenticatedListener;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AbstractControllerTest
 * @package App\Tests\Http\Controller
 */
abstract class AbstractControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    /**
     * @var string
     */
    private $httpVerb;

    /**
     * @var string
     */
    private $method;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var string|null
     */
    private $responseClass;

    /**
     * @var array
     */
    private $responseArgs = [];

    /**
     * @var bool
     */
    private $isNotFound = false;

    /**
     * @var bool
     */
    private $isBadRequest = false;

    /**
     * @var bool
     */
    private $setBearer = true;

    /**
     * AbstractControllerTest constructor.
     * @param string $httpVerb
     * @param string $method
     * @param RequestInterface $request
     * @param string|null $responseClass
     * @param bool|null $setBearer
     */
    public function __construct(
        string $httpVerb,
        string $method,
        RequestInterface $request,
        ?string $responseClass = null,
        ?bool $setBearer = true
    )
    {
        parent::__construct(null, [], "");
        $this->httpVerb = $httpVerb;
        $this->method = $method;
        $this->request = $request;
        $this->responseClass = $responseClass;
        $this->setBearer = $setBearer;
    }

    /**
     * Called before each test
     * Client initialisation
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @param array $responseArgs
     */
    protected function assertResponseIsOk(array $responseArgs): void
    {
        $this->responseArgs = $responseArgs;
        $response = $this->getApiCallResponse();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertOnContent($response);
    }

    /**
     * @param array $responseArgs
     */
    protected function assertResponseIsCreated(array $responseArgs): void
    {
        $this->responseArgs = $responseArgs;
        $response = $this->getApiCallResponse();
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertOnContent($response);
    }

    /**
     * @param array $responseArgs
     */
    protected function assertResponseIsEmpty(array $responseArgs): void
    {
        $this->responseArgs = $responseArgs;
        $this->getApiCallResponse();
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    protected function assertResponseIsBadRequest(): void
    {
        $this->isBadRequest = true;
        $this->getApiCallResponse();
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    protected function assertResponseIsNotFound(): void
    {
        $this->isNotFound = true;
        $this->getApiCallResponse();
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    protected function assertResponseIsForbidden(): void
    {
        $this->getApiCallResponse();
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    /**
     * @param Response $response
     */
    private function assertOnContent(Response $response): void
    {
        self::assertInstanceOf(
            $this->responseClass,
            $this->getSerializer()->deserialize($response->getContent(), $this->responseClass, "json")
        );
    }

    /**
     * @return Response
     */
    private function getApiCallResponse(): Response
    {
        $this->mockRequestBus();

        $server = [];
        if($this->setBearer) {
            $mockedJwtAuthenticatedListener = self::createMock(JwtAuthenticatedListener::class);
            $mockedJwtAuthenticatedListener->expects(self::once())->method("onJWTAuthenticated");
            self::$container->set(JwtAuthenticatedListener::class, $mockedJwtAuthenticatedListener);
            $server = ["HTTP_AUTHORIZATION" => "Bearer {$this->getToken()}"];
        }

        if ($isCommand = is_subclass_of($this->request, CommandInterface::class)) {
            $server["CONTENT_TYPE"] = "application/json";
        }

        $this->client->request(
            $this->httpVerb,
            $this->method,
            [],
            [],
            $server,
            $isCommand ? $this->getSerializer()->serialize($this->request, "json") : null);

        return $this->client->getResponse();
    }

    /**
     * @return SerializerInterface
     */
    private function getSerializer(): SerializerInterface
    {
        /** @var SerializerInterface $serializer */
        $serializer = self::$container->get(SerializerInterface::class);
        return $serializer;
    }

    private function mockRequestBus(): void
    {
        $mockedRequestBusInterface = self::createMock(RequestBusInterface::class);

        if ($this->isNotFound) {
            $mockedRequestBusInterface
                ->expects(self::once())
                ->method("dispatch")
                ->with($this->request)
                ->willThrowException(new NoResultException());
        } elseif ($this->isBadRequest) {
            $mockedRequestBusInterface
                ->expects(self::once())
                ->method("dispatch")
                ->with($this->request)
                ->willThrowException(new DomainException());
        } else {
            $mockedRequestBusInterface
                ->expects(self::once())
                ->method("dispatch")
                ->with(self::equalTo($this->request))
                ->will(self::returnValue(
                    $this->responseClass ?
                        self::getMockBuilder($this->responseClass)
                            ->setConstructorArgs($this->responseArgs)
                            ->setMethods()
                            // Force the mocked class to have different names and avoid cache conflicts
                            ->setMockClassName(uniqid(Extractor::getClassShortName($this->responseClass)))
                            ->getMock() :
                        null
                ));
        }


        self::$container->set(RequestBusInterface::class, $mockedRequestBusInterface);
    }

    /**
     * @return string
     */
    private function getToken(): string
    {
        $userTokenWrapper = new UserTokenWrapper("sub", [], "jti");
        $userTokenWrapper->setIssuer("issuer");
        /** @var AuthenticationProvider $authenticationProvider */
        $authenticationProvider = self::$container->get(AuthenticationProvider::class);
        return $authenticationProvider->generateToken($userTokenWrapper);
    }

    /**
     * @return RequestInterface
     */
    public function getRequestInterface(): RequestInterface
    {
        return $this->request;
    }
}