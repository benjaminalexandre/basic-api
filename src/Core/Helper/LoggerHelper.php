<?php declare(strict_types=1);

namespace App\Core\Helper;

/**
 * Class LoggerHelper
 * @package App\Core\Helper
 */
class LoggerHelper
{
    /**
     * @var string
     */
    private $uniqid;

    /**
     * @var string|null
     */
    private $terminateEventBuffer;

    /**
     * LoggerHelper constructor.
     */
    public function __construct()
    {
        $this->uniqid = uniqid();
    }

    /**
     * @return string
     */
    public function getUniqid(): string
    {
        return $this->uniqid;
    }

    /**
     * @return null|string
     */
    public function getTerminateEventBuffer(): ?string
    {
        return $this->terminateEventBuffer;
    }

    /**
     * @param null|string $terminateEventBuffer
     */
    public function setTerminateEventBuffer(?string $terminateEventBuffer): void
    {
        $this->terminateEventBuffer = $terminateEventBuffer;
    }
}