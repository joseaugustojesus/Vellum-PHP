<?php

namespace src\interfaces;

interface NotificationInterface
{
    function success(string $message): void;

    function info(string $message): void;

    function error(string $message): void;

    function warning(string $message): void;

    function back(): void;
}