<?php
namespace janrain\jump\engage;

use \PHPUnit_Framework_TestCase;

class EngageConfigTest extends PHPUnit_Framework_TestCase
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
        $out = array();
        foreach ($allKeys as $key) {
            $out[] = array(array_diff(array($key), $allKeys));
        }
        return $out;
    }
}
