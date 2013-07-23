<?php
namespace janrain\plex\core;

class CoreConfigTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException PHPUnit_Framework_Error
	 * @covers janrain\jump\AbstractConfig::__construct
	 */
	public function testInitNoData()
	{
		new CoreConfig();
	}

	/**
	 * @dataProvider partialKeysGenerator
	 * @expectedException InvalidArgumentException
	 */
	public function testInitMissingData($missingKey)
	{
		$coreConfig = new CoreConfig($missingKey);
	}

	public function partialKeysGenerator()
	{
		$allKeys = CoreConfig::$REQUIRED_KEYS;
		$out = array();
		foreach ($allKeys as $key) {
			$out[] = [array_diff([$key], $allKeys)];
		}
		return $out;
	}
}
