<?php

namespace app\classes;

/**
 * Pegando URI
 */
class Uri
{
    public static function uri()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

}