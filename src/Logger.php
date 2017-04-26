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
     * @param int|null $category
     * @return bool|\Fei\ApiClient\ResponseDescriptor
     */
    public function debug(string $message, int $category = null)
    {
        return $this->notify(
            $this->buildNotification(Notification::LVL_DEBUG, $category)
                ->setMessage($message)
        );
    }

    /**
     * @param string $message
     * @param int|null $category
     * @return bool|\Fei\ApiClient\ResponseDescriptor
     */
    public function info(string $message, int $category = null)
    {
        return $this->notify(
            $this->buildNotification(Notification::LVL_INFO, $category)
                ->setMessage($message)
        );
    }

    /**
     * @param string $message
     * @param int|null $category
     * @return bool|\Fei\ApiClient\ResponseDescriptor
     */
    public function warning(string $message, int $category = null)
    {
        return $this->notify(
            $this->buildNotification(Notification::LVL_WARNING, $category)
                ->setMessage($message)
        );
    }

    /**
     * @param string $message
     * @param int|null $category
     * @return bool|\Fei\ApiClient\ResponseDescriptor
     */
    public function error(string $message, int $category = null)
    {
        return $this->notify(
            $this->buildNotification(Notification::LVL_ERROR, $category)
                ->setMessage($message)
        );
    }

    /**
     * @param string $message
     * @param int|null $category
     * @return bool|\Fei\ApiClient\ResponseDescriptor
     */
    public function panic(string $message, int $category = null)
    {
        return $this->notify(
            $this->buildNotification(Notification::LVL_PANIC, $category)
                ->setMessage($message)
        );
    }

    /**
     * @param $level
     * @param $category
     * @return Notification
     */
    protected function buildNotification($level, $category): Notification
    {
        return new Notification([
            'level' => $level,
            'category' => $category
        ]);
    }
}
