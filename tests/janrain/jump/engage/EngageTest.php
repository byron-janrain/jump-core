<?php
namespace janrain\jump\engage;

use janrain\plex\GenericConfig;

class EngageTest extends \PHPUnit_Framework_TestCase
{
    protected $config;
    protected $engage;

    public function setUp() {

        $this->config = $this->getMockBuilder(__NAMESPACE__ . '\\EngageConfig')
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
        $out = array();
        $requiredEngageOpts = array_combine(EngageConfig::$REQUIRED_KEYS, EngageConfig::$REQUIRED_KEYS);
        $configWithCapture = new GenericConfig($requiredEngageOpts);
        $configWithCapture->setItem('features', array('Engage', 'Capture'));
        $out[] = array($configWithCapture);
        $configNoCapture = new GenericConfig($requiredEngageOpts);
        $configNoCapture->setItem('features', array('Engage'));
        $out[] = array($configNoCapture);
        return $out;
    }
}
