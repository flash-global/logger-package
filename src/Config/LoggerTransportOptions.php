<?php

namespace Fei\Service\Logger\Package\Config;

use ObjectivePHP\Config\SingleValueDirective;

/**
 * Class LoggerTransportOptions
 * @package Fei\Service\Logger\Package
 */
class LoggerTransportOptions extends SingleValueDirective
{
    /**
     * LoggerTransportOptions constructor.
     * @param array $value
     */
    public function __construct(array $value = [])
    {
        parent::__construct($value);
    }

    /**
     * Set the options for the basic transport
     * @param array $options
     * @return LoggerTransportOptions
     */
    public function setOptions(array $options) : LoggerTransportOptions
    {
        $this->value = $options;
        return $this;
    }
}
