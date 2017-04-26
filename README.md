# Logger Package

This package provide Logger Client integration for Objective PHP applications.

## Installation

Logger Package needs **PHP 7.0** or up to run correctly.

You will have to integrate it to your Objective PHP project with `composer require fei/logger-package`.


## Integration

As shown below, the Logger Package must be plugged in the application initialization method.

The Logger Package create a Logger Client service that will be consumed by the application's middlewares.

```php
<?php

use ObjectivePHP\Application\AbstractApplication;
use ObjectivePHP\Package\Logger\LoggerPackage;

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
### Application configuration

Create a file in your configuration directory and put your Logger configuration as below:

```php
<?php
use ObjectivePHP\Package\Logger\Config\LoggerParam;
use Fei\Service\Logger\Client\Logger;

return [
    new LoggerParam([Logger::OPTION_BASEURL => 'http://logger.dev:8181']),
];
```

In the previous example you need to set this configuration:

* `LoggerParam` : represent the URL where the API can be contacted in order to send the mails

Please check out `logger-client` documentation for more information about how to use this client.