<?php
namespace janrain\jump;

use janrain\jump\core\Core;
use janrain\plex\GenericConfig;

class ConfigBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $config = ConfigBuilder::build(Core::class, new GenericConfig(['features' => [], 'jumpUrl' => '']));
        $this->assertInstanceOf(AbstractConfig::class, $config);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testBuildBadClass()
    {
        ConfigBuilder::build('WRONGCLASS', new GenericConfig());
    }
}
