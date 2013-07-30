<?php
namespace janrain\jump\capture;

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
        $out = [];
        foreach ($allKeys as $key) {
            $out[] = [array_diff([$key], $allKeys)];
        }
        return $out;
    }
}