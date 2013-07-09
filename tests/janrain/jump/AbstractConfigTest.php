<?php
namespace janrain\jump;

class AbstractConfigTest extends \PHPUnit_Framework_TestCase
{

	public function testInit()
	{
		$mock = $this->getMockForAbstractClass(__NAMESPACE__ . '\AbstractConfig', array(array('key1' => 'value1')));
		return $mock;
	}
/*
	/**
	 * @depends testInit
	 * /
	public function testCount($mock)
	{
		$this->assertEquals(1, count($mock));
	}

	/**
	 * @depends testInit
	 * /
	public function testGetIterator($mock)
	{
		$this->assertInstanceOf('Traversable', $mock->getIterator());
	}

	/**
	 * @depends testInit
	 * /
	public function testOffsetGetReturnsNullForMissingKey($mock)
	{
		$out = $mock['nokey'];
		$this->assertEquals(null, $out);
	}

	/**
	 * @depends testInit
	 * /
	public function testOffsetGet($mock)
	{
		$this->assertEquals('value1', $mock['key1']);
	}

	public function testOffsetUnset()
	{
		$mock = $this->getMockForAbstractClass(__NAMESPACE__ . '\AbstractConfig', array(array('key1' => 'value1')));
		unset($mock['key1']);
		$this->assertEquals(null, $mock['key1']);
	}

	public function testOffsetSet()
	{
		$mock = $this->getMockForAbstractClass(__NAMESPACE__ . '\AbstractConfig', array(array()));
		$mock['key1'] = 'value1';
		$this->assertEquals('value1', $mock['key1']);
		$mock->offsetSet('key1', 'value2');
		$this->assertEquals('value2', $mock['key1']);
		$mock->setKey1('value3');
		$this->assertEquals('value3', $mock['key1']);
	}
	*/
}
