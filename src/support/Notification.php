<?php

namespace src\support;

use src\interfaces\NotificationInterface;

class Notification implements NotificationInterface
{
    /**
     * @param string $message
     */
    function success(string $message): void
    {
        notification($message, "success");
    }

    /**
     * @param string $message
     */
    function info(string $message): void
    {
        notification($message, "info");
    }

    /**
     * @param string $message
     */
    function error(string $message): void
    {
        notification($message, "error");
    }

    /**
     * @param string $message
     */
    function warning(string $message): void
    {
        notification($message, "warning");
    }
}
