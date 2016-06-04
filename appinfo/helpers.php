<?php

/**
 * Get config array.
 *
 * @param string|null $section
 *
 * @return array|null
 */
function config($section = null)
{
    $config = include 'cbreederconfig.php';
    if (is_null($section)) {
        return $config;
    } else {
        return array_key_exists($section, $config)
            ? $config[$section]
            : null;
    }
}
