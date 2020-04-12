<?php declare(strict_types=1);

namespace App\Http\Middleware\ParamConverter;

use App\Core\Utils\DateTime;
use ReflectionFunction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class BodyParamConverter
 * @package App\Http\Middleware\ParamConverter
 */
class BodyParamConverter implements ParamConverterInterface
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param ParamConverter $configuration
     * @return bool
     * @throws \Exception
     */
    public function supports(ParamConverter $configuration): bool
    {
        if (is_string($configuration->getClass()) && !class_exists($configuration->getClass())) {
            throw new \Exception(
                __CLASS__ . " - " . __FUNCTION__ . " - " . "Class not found : {$configuration->getClass()}"
            );
        }

        return $configuration->getConverter() === "http.body";
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool
     * @throws \Exception
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $class = $request->attributes->get("_converters")[0]->getClass();
        $params = array_merge($request->attributes->get("_route_params"));
        $command = $this->serializer->deserialize(
            $request->getContent(),
            $class,
            "json"
        );

        foreach ($params as $attribute => $value) {
            $setter = "set{$attribute}";
            if (method_exists($command, $setter)) {
                try {
                    $value = intval($value);
                    $command->$setter($value);
                } catch (\TypeError $e) {
                    throw new BadRequestHttpException($e->getMessage());
                }
            } else {
                throw new \Exception(
                    __CLASS__ . " - " . __FUNCTION__ . " - " . "Method not found : $setter"
                );
            }
        }

        $request->attributes->set($configuration->getName(), $command);

        return true;
    }
}