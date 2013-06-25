<?php
namespace janrain;

use PHPUnit_Framework_TestCase;

class JumpTest extends PHPUnit_Framework_TestCase
{

	protected $mockConf;

	public function setUp()
	{
		$this->mockConf = $this->getMockBuilder('janrain\jump\AbstractConfig')
			->disableOriginalConstructor()
			->getMock();
	}

	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testInitNoConfig()
	{
		Jump::getInstance();
	}

	public function testInitConfig()
	{
		Jump::getInstance($this->mockConf);
	}
}
