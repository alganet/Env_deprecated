<?php

namespace Respect\Env\Adapters;

use Respect\Env\Wrappable;

class Raw implements Wrappable
{

    public function getenv($varname)
    {
        return getenv($varname);
    }

    public function putenv($setting)
    {
        return putenv($setting);
    }

    public function shell_exec($command)
    {
        return shell_exec($command);
    }

    public function sys_get_temp_dir()
    {
        return sys_get_temp_dir();
    }

    public function filter_input($type, $variable_name, $filter=FILTER_DEFAULT,
        $options=null)
    {
        return filter_input($type, $variable_name, $filter, $options);
    }

    public function filter_input_array($type, $definition=null)
    {
        return filter_input_array($type, $definition);
    }

    public function filter_has_var($type, $variable_name)
    {
        return filter_has_var($type, $variable_name);
    }

    public function file_get_contents($filename, $use_include_path=false,
        $context=null, $offset=null, $maxlen=null)
    {
        switch (func_num_args()) {
            case 1:
            case 2 :
            case 3:
                return file_get_contents(
                    $filename, $use_include_path, $context
                );
                break;
            case 4:
            case 5:
                return file_get_contents(
                    $filename, $use_include_path, $context, $offset, $maxlen
                );
                break;
        }
    }

    public function is_writable($filaname)
    {
        return is_writable($filename);
    }

    public function file_exists($filaname)
    {
        return file_exists($filename);
    }

    public function file_put_contents($filename, $data, $flags=0, $context=null)
    {
        return file_put_contents($filename, $data, $flags, $context);
    }

}
