<?php
namespace janrain\plex\engage;

use \PHPUnit_Framework_TestCase;

class EngageTest extends PHPUnit_Framework_TestCase
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

	public function testGetSettingsHeadJsReturnsString() {
		$this->assertInternalType('string', $this->engage->getSettingsHeadJs());
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
}
