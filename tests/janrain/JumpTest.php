<?php
namespace janrain;

use janrain\plex\GenericConfig;

class JumpTest extends \PHPUnit_Framework_TestCase
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

    public function testGetFeature()
    {
        $jump = Jump::getInstance();
        $this->assertEquals(null, $jump->getFeature('Capture'));
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
        $noFeatures = new GenericConfig([]);
        $jump->init($noFeatures);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInitInvalidFeature()
    {
        $jump = Jump::getInstance();
        $badFeatures = new GenericConfig(['features' => ['INVALIDFEATURE']]);
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
        $this->assertInstanceOf(jump\FeatureStack::class, $features);
    }


    public function initGen()
    {
        return [
            [new GenericConfig(['features' => ['Core'], 'jumpUrl' => 'string'])],
            [new GenericConfig(
                ['features' => ['Core', 'Capture'],
                'jumpUrl' => 'string',
                'capture.appId' => '',
                'capture.clientId' => '',
                'capture.captureServer' => '']
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

    public function testGetHtml()
    {
        $jump = Jump::getInstance();
        $this->assertSame('', $jump->getHtml());
    }
}
