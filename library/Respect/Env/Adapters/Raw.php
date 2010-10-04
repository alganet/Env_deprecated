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

}
