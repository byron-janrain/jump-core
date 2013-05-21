<?php
namespace janrain\plex;

use \PHPUnit_Framework_TestCase;

class CaptureConfigTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInitNoData() {
		new CaptureConfig(array());
	}
}
