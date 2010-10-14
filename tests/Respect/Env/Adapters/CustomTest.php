<?php

namespace Respect\Env\Adapters;

class CustomTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    protected function setUp()
    {
        $this->object = new Custom;
    }

    public function testGetenv()
    {
        $this->object->setEnvVars(array(
            'foo' => 'bar'
        ));
        $this->assertEquals('bar', $this->object->getenv('foo'));
    }

    public function testPutenv()
    {
        $this->object->putenv('foo=bar');
        $this->assertEquals('bar', $this->object->getenv('foo'));
    }

    public function testShellExec()
    {
        $this->object->setShellCallback(
            function() {
                return 'foobar';
            }
        );
        $this->assertEquals('foobar', $this->object->shell_exec('sofub'));
    }

    public function testSysGetTempDir()
    {
        $this->object->setTempFolder('/foo/bar');
        $this->assertEquals('/foo/bar', $this->object->sys_get_temp_dir());
    }

    public function testFilterPost()
    {
        $this->object->setPostVars(array(
            'foo' => 'bar'
        ));
        $this->assertEquals('bar',
            $this->object->filter_input(INPUT_POST, 'foo'));
        $this->assertTrue($this->object->filter_has_var(INPUT_POST, 'foo'));
    }

    public function testFilterGet()
    {
        $this->object->setGetVars(array(
            'foo' => 'bar'
        ));
        $this->assertEquals('bar', $this->object->filter_input(INPUT_GET, 'foo'));
        $this->assertTrue($this->object->filter_has_var(INPUT_GET, 'foo'));
    }

    public function testFilterCookie()
    {
        $this->object->setCookieVars(array(
            'foo' => 'bar'
        ));
        $this->assertEquals('bar',
            $this->object->filter_input(INPUT_COOKIE, 'foo'));
        $this->assertTrue($this->object->filter_has_var(INPUT_COOKIE, 'foo'));
    }

    public function testFilterSession()
    {
        $this->object->setSessionVars(array(
            'foo' => 'bar'
        ));
        $this->assertEquals('bar',
            $this->object->filter_input(INPUT_SESSION, 'foo'));
        $this->assertTrue($this->object->filter_has_var(INPUT_SESSION, 'foo'));
    }

    public function testFilterServer()
    {
        $this->object->setServerVars(array(
            'foo' => 'bar'
        ));
        $this->assertEquals('bar',
            $this->object->filter_input(INPUT_SERVER, 'foo'));
        $this->assertTrue($this->object->filter_has_var(INPUT_SERVER, 'foo'));
    }

    public function testFilterEnv()
    {
        $this->object->setEnvVars(array(
            'foo' => 'bar'
        ));
        $this->assertEquals('bar', $this->object->filter_input(INPUT_ENV, 'foo'));
        $this->assertEquals('bar', $this->object->getenv('foo'));
        $this->assertTrue($this->object->filter_has_var(INPUT_ENV, 'foo'));
    }

    public function testFilterArray()
    {
        $v = array(
            'num' => 'inv',
            'foo' => 'bar',
            'baz' => 'bat'
        );
        $this->object->setEnvVars($v);
        unset($v['num']);
        $this->assertEquals($v,
            $this->object->filter_input_array(
                INPUT_ENV,
                array(
                'foo' => FILTER_DEFAULT,
                'baz' => FILTER_DEFAULT
                )
            )
        );
    }

    public function testFileSystemFunctions()
    {
        $this->object->file_put_contents('/foo/bar', 'fooBar');
        $this->assertEquals(
            'fooBar', $this->object->file_get_contents('/foo/bar')
        );
    }

}