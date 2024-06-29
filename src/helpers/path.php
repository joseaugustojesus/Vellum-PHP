<?php



/**
 * Its responsible for concat css directory with filename
 *
 * @param string $path
 * @return string
 */
function css_directory($path = '')
{
    return $_ENV["APP_URL"] . "/public/css{$path}";
}

/**
 * Its responsible for concat js directory with filename
 *
 * @param string $path
 * @return string
 */
function js_directory($path = '')
{
    return $_ENV["APP_URL"]  . "/public/js{$path}";
}



function images_directory($path = '')
{
    return $_ENV["APP_URL"] . "/public/images/{$path}";
}
