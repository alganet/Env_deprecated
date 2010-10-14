<?php

namespace Respect\Env;

use Respect\Env\Adapters\Raw;
use Respect\Env\Wrappable;

abstract class Wrapper
{

    public static $current;
    protected static $evaldNs = array();

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

    public static function register()
    {
        self::getCurrent();
    }

    public static function evil($namespace, $force=false)
    {
        if (isset(self::$evaldNs[$namespace]))
            return;
        self::$evaldNs[$namespace] = true;
        if ($force || class_exists('\PHPUnit_Framework_TestCase'))
            eval(
                'namespace ' . $namespace . '; 
            use Respect\Env\Wrapper;
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
            
            function is_writable($filename) 
            {
                return Wrapper::getCurrent()->is_writable($filename);
            }
            
            function file_exists($filename) 
            {
                return Wrapper::getCurrent()->file_exists($filename);
            }
            
            function file_get_contents($filename, $use_include_path=false,
                $context=null, $offset=-1, $maxlen=-1)
            {
                return Wrapper::getCurrent()->file_get_contents($filename, $use_include_path, $context,
                    $offset, $maxlen);
            }

            function file_put_contents($filename, $data, $flags=0, $context=null)
            {
                return Wrapper::getCurrent()->file_put_contents($filename, $data, $flags, $context);
            }'
            );
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