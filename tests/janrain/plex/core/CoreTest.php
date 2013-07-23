<?php
namespace janrain\plex\core;

use PHPUnit_Framework_TestCase;

class CoreTest extends PHPUnit_Framework_TestCase
{
	protected $config;
	protected $core;

	public function setUp() {
		$this->config = $this->getMockBuilder(__NAMESPACE__ . '\CoreConfig')
			->disableOriginalConstructor()
			->getMock();
		$this->core = new Core($this->config);
	}

	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testInitNoConfig() {
		$core = new Core();
	}

	public function testGetHeadJsSrcsReturnsArray() {
		$this->assertInternalType('array', $this->core->getHeadJsSrcs());
	}

	public function testGetStartHeadJsReturnsString() {
		$this->assertInternalType('string', $this->core->getStartHeadJs());
	}

	public function testGetSettingsHeadJsReturnsString() {
		$this->assertInternalType('string', $this->core->getSettingsHeadJs());
	}

	public function testGetEndHeadJsReturnsString() {
		$this->assertInternalType('string', $this->core->getEndHeadJs());
	}

	public function testGetCssHrefsReturnsArray() {
		$this->assertInternalType('array', $this->core->getCssHrefs());
	}

	public function testGetCssReturnsString() {
		$this->assertInternalType('string', $this->core->getCss());
	}

	public function testGetHtmlReturnsString() {
		$this->assertInternalType('string', $this->core->getHtml());
	}
}
