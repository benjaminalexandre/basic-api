<?php

namespace App\Http\Middleware\ParamConverter;

use App\Core\Utils\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class RouteParamConverter
 * @package App\Http\Middleware\ParamConverter
 *
 * If you want to call RouteParamConverter please follow this example by adding the annotation :
 *   => ParamConverter(name="getUser", class=GetUserQuery::class, converter="http.route")
 *     - name : name of the returned parameter in the controller function
 *     - class : Class in which the parameters of the query will be converted
 *       /!\ Should only be used with Query classes /!\
 * If an exception is raised then it's a developer issue, shouldn't happened in production environment
 */
class RouteParamConverter implements ParamConverterInterface
{
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

		return $configuration->getConverter() === "http.route";
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
		$query = new $class();
		$params = array_merge($request->attributes->get("_route_params"), $request->query->all());
		foreach ($params as $attribute => $value) {
			$setter = "set{$attribute}";
			if (method_exists($query, $setter)) {
				try {
					if (!is_array($value) && DateTime::isDateTime($value)) {
						$value = new \DateTime($value);
						$timezone = new \DateTimeZone(date_default_timezone_get());
						$value->setTimezone($timezone);
					}
					if (method_exists($query, "is{$attribute}")) {
						$value = ($value === "false" || $value === false) ? false : true;
					}
					$query->$setter($value);
				} catch (\TypeError $e) {
					throw new BadRequestHttpException($e->getMessage());
				}
			} else {
				throw new \Exception(
					__CLASS__ . " - " . __FUNCTION__ . " - " . "Method not found : $setter"
				);
			}
		}

		$request->attributes->set($configuration->getName(), $query);

		return true;
	}
}