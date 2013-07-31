<?php
namespace janrain\jump\capture;

class CaptureTest extends \PHPUnit_Framework_TestCase
{
    protected $config;
    protected $capture;

    public function setUp()
    {
        $this->config = $this->getMockBuilder(CaptureConfig::class)
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

    /**
     * @dataProvider ConfigGen
     */
    public function testGetApi($config)
    {
        $captureConf = new CaptureConfig($config);
        $capture = new Capture($captureConf);
        $api = $capture->getApi();
        $this->assertInstanceOf(\janrain\jump\captureapi\CaptureApi::class, $api);
    }

    public function configGen()
    {
        $conf = [];
        $reqKs = array_merge(\janrain\jump\captureapi\CaptureAPIConfig::$REQUIRED_KEYS, CaptureConfig::$REQUIRED_KEYS);
        foreach ($reqKs as $k) {
            $conf[$k] = 'testvalue';
        }
        $conf2 = $conf;
        $captureSess = new \stdClass();
        $captureSess->token = '';
        $captureSess->expires = time();
        $conf2['capture.session'] = $captureSess;
        return [
            [$conf],
            [$conf2]
        ];
    }
}
