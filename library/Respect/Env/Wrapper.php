<?php

namespace Respect\Env;

use Respect\Env\Adapters\Raw;
use Respect\Env\Wrappable;

abstract class Wrapper
{

    public static $current;

    public static function set($wrapper)
    {
        if (!$wrapper instanceof Wrappable) {
            $wrapper = 'Respect\\Env\\Adapters\\' . ucfirst($wrapper);
            $wrapper = new $wrapper;
        }
        self::$current = $wrapper;
    }

    public static function getCurrent()
    {
        if (!isset(self::$current)) {
            self::$current = new Raw;
        }
        return self::$current;
    }

}

function getenv($varname)
{
    return Wrapper::getCurrent()->getenv($varname);
}

function putenv($setting)
{
    return Wrapper::getCurrent()->putenv($setting);
}

function shell_exec($command)
{
    return Wrapper::getCurrent()->shell_exec($command);
}

function sys_get_temp_dir()
{
    return Wrapper::getCurrent()->sys_get_temp_dir();
}

function filter_input($type, $variable_name, $filter=FILTER_DEFAULT,
    $options=null)
{
    return Wrapper::getCurrent()->filter_input($type, $variable_name, $filter,
        $options);
}

function filter_input_array($type, $definition=null)
{
    return Wrapper::getCurrent()->filter_input_array($type, $definition);
}

function filter_has_var($type, $variable_name)
{
    return Wrapper::getCurrent()->filter_has_var($type, $variable_name);
}