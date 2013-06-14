<?php
namespace janrain\plex;

use PHPUnit_Framework_TestCase;

class FeaturesTest extends PHPUnit_Framework_TestCase
{
	public function testInit()
	{
		$config = $this->getMock(__NAMESPACE__ . '\core\CoreConfigInterface');
		return new Core($config);
	}

	public function testPushFeatureCapture()
	{
		$config = $this->getMock(__NAMESPACE__ . '\core\CoreConfigInterface');
		$core = new Core($config);

		$captureConfig = $this->getMock(__NAMESPACE__ . '\capture\CaptureConfigInterface');
		$capture = new capture\Capture($captureConfig);

		$core->pushFeature($capture);

		$this->assertStringEndsWith($capture->getStartHeadJs(), $core->getStartHeadJs());
	}
}
