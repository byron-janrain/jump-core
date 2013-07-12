<?php
namespace janrain\plex;

class CoreConfigTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException PHPUnit_Framework_Error
	 * @covers janrain\plex\AbstractConfig::__construct
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
			$out[] = array(array_diff(array($key), $allKeys));
		}
		return $out;
	}
}
