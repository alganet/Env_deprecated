<?php

namespace Respect\Env\Adapters;

use Respect\Env\Wrappable;

class Custom implements Wrappable
{

    protected $postVars = array();
    protected $getVars = array();
    protected $envVars = array();
    protected $cookieVars = array();
    protected $sessionVars = array();
    protected $serverVars = array();
    protected $shellCallback;
    protected $tempFolder;
    protected $fileSystem = array();
    protected $writableFiles = array();

    public function import()
    {
        $this->setPostVars($_POST);
        $this->setGetVars($_GET);
        $this->setEnvVars($_ENV);
        $this->setCookieVars($_COOKIE);
        if (isset($_SESSION))
            $this->setSessionVars($_SESSION);
        $this->setServerVars($_SERVER);
        $this->setShellCallback('shell_exec');
        $this->setTempFolder('sys_get_temp_dir');
    }

    public function setPostVars(array $postVars)
    {
        $this->postVars = $postVars;
    }

    public function setGetVars(array $getVars)
    {
        $this->getVars = $getVars;
    }

    public function setEnvVars(array $envVars)
    {
        $this->envVars = $envVars;
    }

    public function setCookieVars(array $cookieVars)
    {
        $this->cookieVars = $cookieVars;
    }

    public function setSessionVars(array $sessionVars)
    {
        $this->sessionVars = $sessionVars;
    }

    public function setServerVars(array $serverVars)
    {
        $this->serverVars = $serverVars;
    }

    public function setShellCallback($shellCallback)
    {
        $this->shellCallback = $shellCallback;
    }

    public function setTempFolder($tempFolder)
    {
        $this->tempFolder = $tempFolder;
    }

    public function setWritableFiles(array $writableFiles)
    {
        $this->writableFiles = $writableFiles;
    }

    public function setFileSystem(array $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function getenv($varname)
    {
        return $this->envVars[$varname];
    }

    public function putenv($setting)
    {
        list($varname, $value) = explode('=', $setting);
        $this->envVars[$varname] = $value;
    }

    public function shell_exec($command)
    {
        return call_user_func($this->shellCallback, $command);
    }

    public function sys_get_temp_dir()
    {
        return $this->tempFolder;
    }

    public function filter_input($type, $variable_name, $filter=FILTER_DEFAULT,
        $options=null)
    {
        $vars = $this->getVarsReference($type);
        return filter_var($vars[$variable_name], $filter, $options);
    }

    public function filter_input_array($type, $definition=null)
    {
        $vars = $this->getVarsReference($type);
        return filter_var_array($vars, $definition);
    }

    public function filter_has_var($type, $variable_name)
    {
        $vars = $this->getVarsReference($type);
        return isset($vars[$variable_name]);
    }

    public function is_writable($filename)
    {
        return isset($this->writableFiles[$filename]);
    }

    public function file_exists($filename)
    {
        return isset($this->fileSystem[$filename]);
    }

    public function file_get_contents($filename, $use_include_path=false,
        $context=null, $offset=-1, $maxlen=-1)
    {
        if (!isset($this->fileSystem[$filename]))
            trigger_error(
                'file_get_contents() failed to open stream: No such file or directory',
                E_USER_WARNING
            );
        return $this->fileSystem[$filename];
    }

    public function file_put_contents($filename, $data, $flags=0, $context=null)
    {
        $this->fileSystem[$filename] = $data;
        return strlen($data);
    }

    protected function &getVarsReference($type)
    {
        switch ($type) {
            case INPUT_POST:
                return $this->postVars;
            case INPUT_GET:
                return $this->getVars;
            case INPUT_COOKIE:
                return $this->cookieVars;
            case INPUT_ENV:
                return $this->envVars;
            case INPUT_SERVER:
                return $this->serverVars;
            case INPUT_SESSION:
                return $this->sessionVars;
        }
    }

}
