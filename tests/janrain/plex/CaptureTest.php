<?php
namespace janrain\plex;

use \PHPUnit_Framework_TestCase;

class CaptureTest extends PHPUnit_Framework_TestCase
{
	protected $config;
	protected $capture;

	public function setUp() {

		$this->config = $this->getMockBuilder(__NAMESPACE__ . '\CaptureConfigInterface')
			->getMock();
		foreach (\janrain\plex\CaptureConfig::getRequiredKeys() as $key) {
			$this->config[$key] = "1";
		}
		$this->capture = new Capture($this->config);
	}

	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testInitNoConfig() {
		$capture = new Capture();
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInitInvalidConfig() {
		$config = $this->getMockBuilder(__NAMESPACE__ . '\CaptureConfigInterface')->getMock();
		$capture = new Capture($config);
	}


	public function testGetJsSrcsReturnsArray() {
		$this->assertInternalType('array', $this->capture->getJsSrcs());
	}

	public function testGetStartHeadJsReturnsString() {
		$this->assertInternalType('string', $this->capture->getStartHeadJs());
	}

	public function testGetSettingsHeadJsReturnsString() {
		$this->assertInternalType('string', $this->capture->getSettingsHeadJs());
	}

	public function testGetEndHeadJsReturnsString() {
		$this->assertInternalType('string', $this->capture->getEndHeadJs());
	}

	public function testGetCssHrefsReturnsArray() {
		$this->assertInternalType('array', $this->capture->getCssHrefs());
	}

	public function testGetCssReturnsString() {
		$this->assertInternalType('string', $this->capture->getCss());
	}

	public function testGetHtmlReturnsString() {
		$this->assertInternalType('string', $this->capture->getHtml());
	}
}
