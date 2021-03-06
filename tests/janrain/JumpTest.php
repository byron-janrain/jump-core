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
        $this->assertInstanceOf(__NAMESPACE__ . '\\'. 'Jump', $jump);
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
        $noFeatures = new GenericConfig(array());
        $jump->init($noFeatures);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInitInvalidFeature()
    {
        $jump = Jump::getInstance();
        $badFeatures = new GenericConfig(array('features' => array('INVALIDFEATURE')));
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
        $this->assertInstanceOf(__NAMESPACE__ . '\\jump\\FeatureStack', $features);
    }


    public function initGen()
    {
        $coreConfigFake = array_combine(
            \janrain\jump\core\CoreConfig::$REQUIRED_KEYS,
            \janrain\jump\core\CoreConfig::$REQUIRED_KEYS);
        $captureConfigFake = array_combine(
            \janrain\jump\capture\CaptureConfig::$REQUIRED_KEYS,
            \janrain\jump\capture\CaptureConfig::$REQUIRED_KEYS);
        $captureApiConfigFake = array_combine(
            \janrain\jump\captureapi\CaptureApiConfig::$REQUIRED_KEYS,
            \janrain\jump\captureapi\CaptureApiConfig::$REQUIRED_KEYS);
        return array(
            array(new GenericConfig(array('features' => array('Core'), 'jumpUrl' => 'string'))),
            array(new GenericConfig(
                array_merge(
                    array('features' => array('Core','CaptureApi', 'Capture')),
                    $coreConfigFake,
                    $captureConfigFake,
                    $captureApiConfigFake))),
        );
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
