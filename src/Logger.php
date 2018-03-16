<?php

namespace Fei\Service\Logger\Package;

use Fei\Service\Logger\Client\Logger as LoggerClient;
use Fei\Service\Logger\Entity\Notification;

/**
 * Class Logger
 * @package ObjectivePHP\Package\Logger
 */
class Logger extends LoggerClient
{
    /**
     * @param string $message
     * @param array $context
     * @param string $namespace
     * @param int|null $category
     * @return bool|\Fei\ApiClient\ResponseDescriptor
     */
    public function debug(string $message, array $context = [], string $namespace = '', int $category = null)
    {
        return $this->notify($this->buildNotification(Notification::LVL_DEBUG, $category, $namespace, $message, $context));
    }

    /**
     * @param string $message
     * @param array $context
     * @param string $namespace
     * @param int|null $category
     * @return bool|\Fei\ApiClient\ResponseDescriptor
     */
    public function info(string $message, array $context = [], string $namespace = '', int $category = null)
    {
        return $this->notify($this->buildNotification(Notification::LVL_INFO, $category, $namespace, $message, $context));
    }

    /**
     * @param string $message
     * @param array $context
     * @param string $namespace
     * @param int|null $category
     * @return bool|\Fei\ApiClient\ResponseDescriptor
     */
    public function warning(string $message, array $context = [], string $namespace = '', int $category = null)
    {
        return $this->notify($this->buildNotification(Notification::LVL_WARNING, $category, $namespace, $message, $context));
    }

    /**
     * @param string $message
     * @param array $context
     * @param string $namespace
     * @param int|null $category
     * @return bool|\Fei\ApiClient\ResponseDescriptor
     */
    public function error(string $message, array $context = [], string $namespace = '', int $category = null)
    {
        return $this->notify($this->buildNotification(Notification::LVL_ERROR, $category, $namespace, $message, $context));
    }

    /**
     * @param string $message
     * @param array $context
     * @param string $namespace
     * @param int|null $category
     * @return bool|\Fei\ApiClient\ResponseDescriptor
     */
    public function panic(string $message, array $context = [], string $namespace = '', int $category = null)
    {
        return $this->notify($this->buildNotification(Notification::LVL_PANIC, $category, $namespace, $message, $context));
    }


    /**
     * @param int $level
     * @param int $category
     * @param string $namespace
     * @param string $message
     * @param array $context
     * @return Notification
     */
    protected function buildNotification(int $level, int $category, string $namespace, string $message, array $context): Notification
    {
        return (new Notification())
            ->setLevel($level)
            ->setCategory($category)
            ->setNamespace($namespace)
            ->setMessage($message)
            ->setContext($context);
    }
}
