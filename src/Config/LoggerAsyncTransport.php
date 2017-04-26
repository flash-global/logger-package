<?php

namespace Fei\Service\Logger\Package\Config;

use ObjectivePHP\Config\SingleValueDirective;
use Pheanstalk\PheanstalkInterface;

/**
 * Class LoggerAsyncTransport
 * @package Fei\Service\Logger\Package
 */
class LoggerAsyncTransport extends SingleValueDirective
{
    /**
     * LoggerAsyncTransport constructor.
     * @param string $host
     * @param int $port
     */
    public function __construct(string $host = '127.0.0.1', int $port = PheanstalkInterface::DEFAULT_PORT)
    {
        parent::__construct([
            'host' => $host,
            'port' => $port
        ]);
    }

    /**
     * Set the host of the async transport
     * @param string $host
     * @return LoggerAsyncTransport
     */
    public function setHost(string $host) : LoggerAsyncTransport
    {
        $this->value['host'] = $host;
        return $this;
    }

    /**
     * Set the port of the async transport
     * @param integer $port
     * @return LoggerAsyncTransport
     */
    public function setPort(int $port) : LoggerAsyncTransport
    {
        $this->value['port'] = $port;
        return $this;
    }
}
