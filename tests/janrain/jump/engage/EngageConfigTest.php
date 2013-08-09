<?php
namespace janrain\jump\engage;

use janrain\plex\GenericConfig;

class EngageConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInitNoData()
    {
        new EngageConfig();
    }

    public function testInit()
    {
        $conf = new GenericConfig(array_combine(EngageConfig::$REQUIRED_KEYS, EngageConfig::$REQUIRED_KEYS));
        $e = new EngageConfig($conf);
        $this->assertInstanceOf(__NAMESPACE__ . '\\EngageConfig', $e);
    }

    /**
     * @dataProvider partialKeysGenerator
     * @expectedException InvalidArgumentException
     */
    public function testInitMissingData($missingKey)
    {
        $coreConfig = new EngageConfig($missingKey);
    }

    public function partialKeysGenerator()
    {
        $allKeys = EngageConfig::$REQUIRED_KEYS;
        $out = array();
        foreach ($allKeys as $key) {
            $o = new GenericConfig(array_diff(array($key), $allKeys));
            $out[] = array($o);
        }
        return $out;
    }
}
