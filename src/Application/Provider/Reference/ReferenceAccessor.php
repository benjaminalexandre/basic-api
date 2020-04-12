<?php declare(strict_types=1);

namespace App\Application\Provider\Reference;

use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ReferenceAccessor
 * @package App\Application\Provider\Reference
 */
class ReferenceAccessor
{
    /**
     * @var string
     */
    private $country;

    /**
     * ReferenceAccessor constructor.
     * @param string $locale
     */
    public function __construct(string $locale)
    {
        $this->country = $locale;
    }

    /**
     * @param string $reference
     * @param int|string $key
     * @return string
     * @throws NoResultException
     */
    public function getReference(string $reference, $key): string
    {
        $references = $this->parseFile($reference);
        if (array_key_exists($key, $references)) {
            return $references[$key];
        } else {
            throw new NoResultException();
        }
    }

    /**
     * @param null|array $scope
     * @param bool $sort
     * @return array
     */
    public function getReferences(?array $scope, $sort = true): array
    {
        $references = [];
        if ($scope !== null) {
            foreach ($scope as $reference) {
                if (!is_dir($reference)) {
                    $references[$reference] = $this->parseFile($reference, $sort);
                }
            }
        } else {
            $referenceDirectory = opendir($_ENV["PATH_REFERENCES"]);
            while (($file = readdir($referenceDirectory)) !== false) {
                if (!is_dir($file)) {
                    $references[$file] = $this->parseFile($file, $sort);
                }
            }
        }
        return $references;
    }

    /**
     * @param string $reference
     * @param bool $sort
     * @return array
     */
    private function parseFile(string $reference, $sort = true): array
    {
        try {
            $references = Yaml::parseFile($_ENV["PATH_REFERENCES"] . "/$reference/$reference.$this->country.yaml");
            if ($sort) {
                asort($references);
            }
            return $references;
        } catch (\Exception $e) {
            throw new BadRequestHttpException();
        }
    }
}