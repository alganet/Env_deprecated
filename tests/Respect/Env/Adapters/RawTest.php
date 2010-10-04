<?php

namespace Respect\Env\Adapters;

class RawTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    protected function setUp()
    {
        $this->object = new Raw;
    }

    public function testGetenv()
    {
        $this->assertEquals(
            getenv('SCRIPT_NAME'), $this->object->getenv('SCRIPT_NAME')
        );
    }

    public function testPutenv()
    {
        $this->object->putenv('php_test=foobar');
        $this->assertEquals('foobar', getenv('php_test'));
    }

    public function testShellExec()
    {
        $response = $this->object->shell_exec('cd');
        $this->assertEquals($response, shell_exec('cd'));
    }

    public function testSysGetTempDir()
    {
        $this->assertSame(sys_get_temp_dir(), $this->object->sys_get_temp_dir());
    }

    public function testFilterInput()
    {
        $this->assertSame($_SERVER['SCRIPT_NAME'],
            $this->object->filter_input(INPUT_SERVER, 'SCRIPT_NAME'));
    }

    public function testFilterHasVar()
    {
        $this->assertTrue($this->object->filter_has_var(INPUT_SERVER,
                'SCRIPT_NAME'));
        $this->assertFalse($this->object->filter_has_var(INPUT_SERVER, 'AIDS'));
    }

}