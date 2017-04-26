<?php

namespace Fei\Service\Logger\Package;

/**
 * Class LoggerAwareTrait
 * @package Fei\Service\Logger\Package
 */
trait LoggerAwareTrait
{
    /** @var  Logger */
    protected $logger;

    /**
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /**
     * @param Logger $logger
     * @return LoggerAwareTrait
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
        return $this;
    }
}
