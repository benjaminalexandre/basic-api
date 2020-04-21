<?php declare(strict_types=1);

namespace App\Core\Utils;

/**
 * Class Extractor
 * @package App\Core\Utils
 */
class Extractor
{
	/**
	 * @param string $className with namespace path
	 * @return string
	 */
	public static function getClassShortName(string $className): string
	{
		$explode = explode('\\', $className);
		return end($explode);
	}
}