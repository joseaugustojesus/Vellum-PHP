<?php


function timezoneDefault(): void
{
    date_default_timezone_set($_ENV["TIMEZONE_DEFAULT"]);
}


function setDebugAsActive(): void
{
    if ($_ENV["DEBUG_ACTIVE"]) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}


function initSessionIfNotStarted(): void
{
    if (session_status() === PHP_SESSION_NONE)
        @session_start();
}



function loadEnv(): void
{
    $dotenv = Dotenv\Dotenv::createMutable(__DIR__ . "/../..");
    $dotenv->load();
}

function bootstrap(): void
{
    \src\core\Bootstrap::run();
}
