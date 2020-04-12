<?php declare(strict_types=1);

namespace App\Application\Provider;

use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Configuration\AutoMapperConfig;

/**
 * Class AbstractAutoMapperConfig
 * @package App\Application\Provider
 */
abstract class AbstractAutoMapperConfig
{
    /**
     * @var AutoMapperInterface
     */
    private $mapper;

    /**
     * @var AutoMapperConfig
     */
    protected $config;

    /**
     * AbstractAutoMapperConfig constructor.
     */
    public function __construct()
    {
        $this->config = new AutoMapperConfig();
        $this->config->getOptions()->dontSkipConstructor();
        $this->initialize();

        $this->mapper = new AutoMapper($this->config);
    }

    /**
     * Mapping configuration
     */
    abstract protected function initialize(): void;

    /**
     * @return AutoMapperInterface
     */
    public function getMapper(): AutoMapperInterface
    {
        return $this->mapper;
    }
}