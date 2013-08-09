<?php
namespace janrain\jump\capture;

use janrain\jump\captureapi\CaptureApi;
use janrain\jump\captureapi\CaptureApiConfig;
use janrain\plex\GenericConfig;

class CaptureTest extends \PHPUnit_Framework_TestCase
{
    protected $config;
    protected $capture;

    public function setUp()
    {
        $this->config = $this->getMockBuilder(__NAMESPACE__ . '\\CaptureConfig')
            ->disableOriginalConstructor()
            ->getMock();
        $this->capture = new Capture($this->config);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInitNoConfig()
    {
        $capture = new Capture();
    }

    public function testGetHeadJsSrcsReturnsArray()
    {
        $this->assertInternalType('array', $this->capture->getHeadJsSrcs());
    }

    public function testGetStartHeadJsReturnsString()
    {
        $this->assertInternalType('string', $this->capture->getStartHeadJs());
    }

    public function testGetSettingsHeadJsReturnsString()
    {
        $this->assertInternalType('string', $this->capture->getSettingsHeadJs());
    }

    /**
     * @dataProvider configGen
    */
    public function testGetEndHeadJsReturnsString($config)
    {
        //var_dump($config);
        $captureConf = new CaptureConfig($config);
        //var_dump($captureConf);
        $capture = new Capture($captureConf);
        //var_dump($capture);
        $this->assertInternalType('string', $capture->getEndHeadJs());
    }

    public function testGetCssHrefsReturnsArray()
    {
        $this->assertInternalType('array', $this->capture->getCssHrefs());
    }

    public function testGetCssReturnsString()
    {
        $this->assertInternalType('string', $this->capture->getCss());
    }

    public function testGetHtmlReturnsString()
    {
        $this->assertInternalType('string', $this->capture->getHtml());
    }

    public function configGen()
    {
        $conf = array();
        $reqKs = array_merge(CaptureAPIConfig::$REQUIRED_KEYS, CaptureConfig::$REQUIRED_KEYS);
        foreach ($reqKs as $k) {
            $conf[$k] = 'testvalue';
        }
        $conf2 = $conf;
        $conf2['capture.session'] = (object) array('token' => 'tokenvalue', 'expires' => time());
        //var_dump($conf2);
        return array(
            array(new GenericConfig($conf)),
            array(new GenericConfig($conf2))
        );
    }
}
