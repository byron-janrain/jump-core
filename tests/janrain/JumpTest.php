<?php
namespace janrain;

use PHPUnit_Framework_TestCase;

class JumpTest extends PHPUnit_Framework_TestCase
{

    protected $mockConf;

    public function setUp()
    {
        $this->mockConf = $this->getMockBuilder('janrain\jump\AbstractConfig')
            ->disableOriginalConstructor()
            ->getMock();
        $this->mockConf
            ->expects($this->any())
            ->method('getIterator')
            ->will($this->returnValue(new \ArrayIterator()));
            //->method()->will();
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInitNoConfig()
    {
        Jump::getInstance();
    }

    public function testInitConfig()
    {
        Jump::getInstance(array('jumpUrl' => 'jumpUrl', 'features' => array()));
    }
}
