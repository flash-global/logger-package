# Logger Package

This package provide Logger Client integration for Objective PHP applications.

## Installation

Logger Package needs **PHP 7.0** or up to run correctly.

You will have to integrate it to your Objective PHP project with `composer require fei/logger-package`.


## Integration

As shown below, the Logger Package must be plugged in the application initialization method.

The Logger Package create a Logger Client service that will be consumed by the application's middlewares.

> IMPORTANT : this package must be plugged at the first step (in this case, bootstrap).

```php
<?php

use ObjectivePHP\Application\AbstractApplication;
use Fei\Service\Logger\Package\LoggerPackage;

class Application extends AbstractApplication
{
    public function init()
    {
        // Define some application steps
        $this->addSteps('bootstrap', 'init', 'auth', 'route', 'rendering');
        
        // Initializations...

        // Plugging the Logger Package in the bootstrap step
        $this->getStep('bootstrap')
        ->plug(LoggerPackage::class);

        // Another initializations...
    }
}
```

You can run this package in an other step. To do this, you just need to do something like that : 

```php
<?php

use ObjectivePHP\Application\AbstractApplication;
use Fei\Service\Logger\Package\LoggerPackage;

class Application extends AbstractApplication
{
    public function init()
    {
        // Define some application steps
        $this->addSteps('bootstrap', 'init', 'auth', 'route', 'rendering');
        
        // Initializations...

        // Plugging the Logger Package in the bootstrap step
        $this->getStep('bootstrap')
        ->plug(new LoggerPackage('identifier.service', 'my.step'));

        // Another initializations...
    }
}
```

* `identifier.service` : represents the service name of logger (default `logger.client`)
* `my.step` : represents the step where the service will be run, in this case, you can put `init`, `auth`, `route`, `rendering` (default `bootstrap`) 

### Application configuration

Create a file in your configuration directory and put your Logger configuration as below:

```php
<?php
use Fei\ApiClient\Config\BasicTransportConfig;
use Fei\ApiClient\Config\BeanstalkTransportConfig;
use Fei\Service\Logger\Package\Config\LoggerClientConfig;

return [
    (new LoggerClientConfig('https://logger.test.flash-global.net'))
            ->setSyncTransportConfig(new BasicTransportConfig())
            ->setAsyncTransportConfig(new BeanstalkTransportConfig('beanstalk.default'))
];
```

In the previous example you need to set this configuration:

* `LoggerClientConfig` : the parameter represents the URL where the API can be contacted in order to send the logs
* `BeanstalkTransportConfig` : represents the service id of beanstalk

Please check out `logger-client` documentation for more information about how to use this client.