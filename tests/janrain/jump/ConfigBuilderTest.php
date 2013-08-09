<?php
namespace janrain\jump;

use janrain\plex\GenericConfig;

class ConfigBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $config = ConfigBuilder::build(
            __NAMESPACE__ . '\\core\\Core', new GenericConfig(array('features' => array(), 'jumpUrl' => '')));
        $this->assertInstanceOf(__NAMESPACE__ . '\\AbstractConfig', $config);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testBuildBadClass()
    {
        ConfigBuilder::build('WRONGCLASS', new GenericConfig());
    }
}
