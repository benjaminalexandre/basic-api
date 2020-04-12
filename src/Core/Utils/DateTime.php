<?php declare(strict_types=1);

namespace App\Core\Utils;

/**
 * Class DateTime
 * @package App\Core\Utils
 */
class DateTime
{
    /**
     * @param string $dateTime
     * @return bool
     */
    public static function isDateTime(string $dateTime): bool
    {
        try {
            $date = new \DateTime($dateTime);
            $date = $date->format(\DateTimeInterface::ISO8601);
            return $date === $dateTime;
        } catch(\Exception $e) {
            return false;
        }
    }
}