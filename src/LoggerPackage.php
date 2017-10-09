<?php

namespace Fei\Service\Logger\Package;

use Fei\ApiClient\Config\BasicTransportConfig;
use Fei\ApiClient\Config\BeanstalkTransportConfig;
use Fei\ApiClient\Transport\BasicTransport;
use Fei\ApiClient\Transport\BeanstalkProxyTransport;
use Fei\Service\Logger\Client\Logger;
use Fei\Service\Logger\Package\Config\LoggerClientConfig;
use ObjectivePHP\Application\ApplicationInterface;
use ObjectivePHP\Application\Middleware\AbstractMiddleware;
use ObjectivePHP\ServicesFactory\Exception\ServiceNotFoundException;

/**
 * Class LoggerPackage
 *
 * @package ObjectivePHP\Package\Logger
 */
class LoggerPackage extends AbstractMiddleware
{

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $bootstrapStep;

    /**
     * LoggerPackage constructor.
     *
     * @param string $loggerClientIdentifier
     * @param string $bootstrapStep
     */
    public function __construct($loggerClientIdentifier = 'logger.client', $bootstrapStep = 'bootstrap')
    {
        $this->identifier = $loggerClientIdentifier;
        $this->bootstrapStep = $bootstrapStep;
    }

    public function run(ApplicationInterface $app)
    {
        if (empty($app->getSteps()[$this->bootstrapStep])) {
            throw new \Exception(sprintf(
                'Cannot plug LoggerPackage to specified application step: "%s" because this step has not been defined.',
                $this->bootstrapStep
            ));
        }

        $app->getStep($this->bootstrapStep)->plug([$this, 'registerServices']);
    }

    /**
     * @param ApplicationInterface $app
     * @throws ServiceNotFoundException
     */
    public function registerServices(ApplicationInterface $app)
    {
        /** @var LoggerClientConfig $clientConfig */
        $clientConfig = $app->getConfig()->get(LoggerClientConfig::class);

        $syncTransport = $clientConfig->getTransportConfig()['sync'];
        $asyncTransport = $clientConfig->getTransportConfig()['async'];

        $setters = [];
        if ($syncTransport instanceof BasicTransportConfig) {
            $setters['setTransport'] = [new BasicTransport($syncTransport->getOptions())];
        }

        // if a config for the async transport is set, we use it
        if ($asyncTransport instanceof BeanstalkTransportConfig) {
            $serviceId = $asyncTransport->getBeanstalkServiceId();

            if (!$app->getServicesFactory()->has($serviceId)) {
                throw new ServiceNotFoundException(sprintf(
                    'No service found in the services factory with the id `%s`',
                    $serviceId
                ));
            }

            $asyncTransport = new BeanstalkProxyTransport($asyncTransport->getOptions());
            $asyncTransport->setPheanstalk($app->getServicesFactory()->get($serviceId));

            $setters['setAsyncTransport'] = [$asyncTransport];
        }

        $params = [
            Logger::OPTION_BASEURL => $clientConfig->getServiceBaseUrl()
        ] + $clientConfig->getParams();

        $app->getServicesFactory()->registerService([
            'id' => $this->identifier,
            'class' => Logger::class,
            'params' => [$params],
            'setters' => $setters
        ]);
    }
}
