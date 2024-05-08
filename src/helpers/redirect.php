<?php


/**
 * Its responsible for redirect for another link/url
 *
 * @param string $to
 * @return void
 */
function redirect(string $to)
{
    header("Location: {$to}");
    exit;
}


/**
 * Its responsible for joining uri with base url from app
 *
 * @param string $route
 * @return string
 */
function route(string $route)
{
    return $_ENV["APP_URL"] . $route;
}

/**
 * Its responsible for return to last url
 *
 * @return string
 */
function url_back()
{
    if (isset($_SERVER['HTTP_REFERER'])) return $_SERVER['HTTP_REFERER'];
    return '#';
}
