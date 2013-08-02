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
        $out = [];
        foreach ($allKeys as $key) {
            $o = new GenericConfig(array_diff([$key], $allKeys));
            $out[] = [$o];
        }
        return $out;
    }
}
