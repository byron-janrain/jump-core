<?php
namespace janrain\jump\engage;

use janrain\plex\GenericConfig;

class EngageTest extends \PHPUnit_Framework_TestCase
{
    protected $config;
    protected $engage;

    public function setUp() {

        $this->config = $this->getMockBuilder(EngageConfig::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->engage = new Engage($this->config);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInitNoConfig() {
        $engage = new Engage();
    }

    public function testGetHeadJsSrcsReturnsArray() {
        $this->assertInternalType('array', $this->engage->getHeadJsSrcs());
    }

    public function testGetStartHeadJsReturnsString() {
        $this->assertInternalType('string', $this->engage->getStartHeadJs());
    }

    /**
     * @dataProvider settingsGen
     */
    public function testGetSettingsHeadJsReturnsString($conf) {
        $engage = new Engage(new EngageConfig($conf));
        $this->assertInternalType('string', $engage->getSettingsHeadJs());
    }

    public function testGetEndHeadJsReturnsString() {
        $this->assertInternalType('string', $this->engage->getEndHeadJs());
    }

    public function testGetCssHrefsReturnsArray() {
        $this->assertInternalType('array', $this->engage->getCssHrefs());
    }

    public function testGetCssReturnsString() {
        $this->assertInternalType('string', $this->engage->getCss());
    }

    public function testGetHtmlReturnsString() {
        $this->assertInternalType('string', $this->engage->getHtml());
    }

    public function testGetPriority()
    {
        return $this->assertEquals('10', $this->engage->getPriority());
    }

    public function settingsGen()
    {
        $out = [];
        $requiredEngageOpts = array_combine(EngageConfig::$REQUIRED_KEYS, EngageConfig::$REQUIRED_KEYS);
        $configWithCapture = new GenericConfig($requiredEngageOpts);
        $configWithCapture->setItem('features', ['Engage', 'Capture']);
        $out[] = [$configWithCapture];
        $configNoCapture = new GenericConfig($requiredEngageOpts);
        $configNoCapture->setItem('features', ['Engage']);
        $out[] = [$configNoCapture];
        return $out;
    }
}
