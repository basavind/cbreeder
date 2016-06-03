<?php

/**
 * Get config array.
 *
 * return mixed
 *
 * @param string|null $section
 *
 * @return mixed|null
 */
function config($section = null)
{
    $config = include_once 'cbreederconfig.php';
    if (is_null($section)) {
        return $config;
    } else {
        return array_key_exists($section, $config)
            ? $config[$section]
            : null;
    }
}
