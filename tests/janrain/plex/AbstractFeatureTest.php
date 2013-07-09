<?php
namespace janrain\plex;

class AbstractFeatureTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testInitNoConfig()
	{
		$mock = $this->getMockForAbstractClass(__NAMESPACE__ . '\AbstractFeature');
	}

	public function testInit()
	{
		$mockConf = $this->getMockForAbstractClass('janrain\jump\AbstractConfig', array(), '', false);
		$mock = $this->getMockForAbstractClass(__NAMESPACE__ . '\AbstractFeature', array($mockConf));
		$this->assertInstanceOf(__NAMESPACE__ . '\AbstractFeature', $mock);
		return $mock;
	}

	/**
	 * @depends testInit
	 */
	public function testIsEnabled(AbstractFeature $mock)
	{
		$this->assertEquals(true, $mock->isEnabled());
	}

	/**
	 * @depends testInit
	 */
	public function testGetName(AbstractFeature $mock)
	{
		$rc = new \ReflectionClass($mock);
		$name = $rc->getShortName();
		$this->assertEquals($mock->getName(), $name);
	}
}
