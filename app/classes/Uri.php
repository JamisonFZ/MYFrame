<?php

namespace app\classes;

/**
 *  Classe Uri
 *  @package app\classes
 */
class Uri
{
    public static function uri()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

}