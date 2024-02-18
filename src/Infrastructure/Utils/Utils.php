<?php

namespace Infrastructure\Utils;

class Utils
{
    static function isDev()
    {
        if (PHP_OS == "WINNT" || strpos(php_uname(), ".dev") !== false
            || strpos(php_uname(), "poldev") !== false
            || strpos(php_uname(), "localhost") !== false
        ) {
            return true;
        }

        return false;
    }
}