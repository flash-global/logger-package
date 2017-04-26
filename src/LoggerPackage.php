<?php

namespace Fei\Service\Logger\Package;

use Fei\ApiClient\Transport\BasicTransport;
use Fei\ApiClient\Transport\BeanstalkProxyTransport;
use Fei\Service\Logger\Package\Config\LoggerAsyncTransport;
use Fei\Service\Logger\Package\Config\LoggerParam;
use Fei\Service\Logger\Package\Config\LoggerTransportOptions;
use ObjectivePHP\Application\ApplicationInterface;
use Pheanstalk\Pheanstalk;
use Pheanstalk\PheanstalkInterface;

/**
 * Class LoggerPackage
 * @package ObjectivePHP\Package\Logger
 */
class LoggerPackage
{
    const DEFAULT_IDENTIFIER = 'logger.client';

    /** @var string */
    protected $identifier;

    /**
     * LoggerClientPackage constructor.
     * @param string $serviceIdentifier
     */
    public function __construct(string $serviceIdentifier = self::DEFAULT_IDENTIFIER)
    {
        $this->identifier = $serviceIdentifier;
    }

    /**
     * @param ApplicationInterface $app
     * @throws \ObjectivePHP\ServicesFactory\Exception\Exception
     */
    public function __invoke(ApplicationInterface $app)
    {
        $config = $app->getConfig();

        $options = $config->get(LoggerTransportOptions::class);
        $options = (is_array($options)) ? $options : [];

        $setters = [
            'setTransport' => [new BasicTransport($options)]
        ];

        // if a config for the async transport is set, we use it
        if ($config->has(LoggerAsyncTransport::class)) {
            $asyncConfig = $config->get(LoggerAsyncTransport::class);
            if (isset($asyncConfig['host'])) {
                $proxy = new BeanstalkProxyTransport();
                $proxy->setPheanstalk(
                    new Pheanstalk($asyncConfig['host'], $asyncConfig['port'] ?? PheanstalkInterface::DEFAULT_PORT)
                );
                $setters['setAsyncTransport'] = [$proxy];
            }
        }

        $app->getServicesFactory()->registerService(
            [
                'id' => $this->identifier,
                'class' => Logger::class,
                'params' => [
                    $app->getConfig()->get(LoggerParam::class),
                ],
                'setters' => $setters
            ]
        );
    }
}
