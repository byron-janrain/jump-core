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

    public function testGetInstance()
    {
        $jump = Jump::getInstance();
        $this->assertInstanceOf(Jump::class, $jump);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInitNoConfig()
    {
        $jump = Jump::getInstance();
        $jump->init();
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInitNoFeatures()
    {
        $jump = Jump::getInstance();
        $noFeatures = new \ArrayObject();
        $jump->init($noFeatures);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInitInvalidFeature()
    {
        $jump = Jump::getInstance();
        $badFeatures = new \ArrayObject(['features' => ['INVALIDFEATURE']]);
        $jump->init($noFeatures);
    }

    /**
     * @dataProvider initGen
     */
    public function testInit($data)
    {
        $jump = Jump::getInstance();
        $jump->init($data);
        $features = $jump->getFeatures();
        $this->assertInstanceOf(plex\FeatureStack::class, $features);
    }


    public function initGen()
    {
        return [
            [new \ArrayObject(['features' => ['Core'], 'jumpUrl' => 'string'])],
            [new \ArrayObject(
                ['features' => ['Core', 'Capture'], 'jumpUrl' => 'string', 'capture.appId' => '', 'capture.clientId' => '', 'capture.captureServer' => '']
                )],
        ];
    }

    /**
     * @covers getHeadSrcsJs getStartHeadJs getEndHeadJs getCssHrefs getCss raw_render
     * @dataProvider initGen
     */
    public function testRawRender($data)
    {
        $jump = Jump::getInstance();
        $jump->init($data);
        $raw_render = $jump->raw_render();
    }
}
