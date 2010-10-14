<?php

namespace Respect\Env;

interface Wrappable
{

    public function getenv($varname);

    public function putenv($setting);

    public function shell_exec($command);

    public function sys_get_temp_dir();

    public function filter_input($type, $variable_name, $filter=FILTER_DEFAULT,
        $options=null);

    public function filter_input_array($type, $definition=null);

    public function filter_has_var($type, $variable_name);
    
    public function file_get_contents($filename, $use_include_path=false, $context=null, $offset=-1, $maxlen=-1);
    
    public function file_put_contents($filename, $data, $flags=0, $context=null);
}