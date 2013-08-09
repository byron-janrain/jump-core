<?php
namespace janrain\jump\capture;

use janrain\plex\GenericConfig;

class CaptureConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInitNoData()
    {
        new CaptureConfig();
    }

    /**
     * @dataProvider partialKeysGenerator
     * @expectedException InvalidArgumentException
     */
    public function testInitMissingData($missingKey)
    {
        $coreConfig = new CaptureConfig($missingKey);
    }

    public function partialKeysGenerator()
    {
        $allKeys = CaptureConfig::$REQUIRED_KEYS;
        $out = array();
        foreach ($allKeys as $key) {
            $out[] = array(new GenericConfig(array_diff(array($key), $allKeys)));
        }
        return $out;
    }
}
