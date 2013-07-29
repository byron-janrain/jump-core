<?php
namespace janrain\jump;

use janrain\jump\core\Core;

class ConfigBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $config = ConfigBuilder::build(Core::class, new \ArrayObject(['features' => [], 'jumpUrl' => '']));
        $this->assertInstanceOf(AbstractConfig::class, $config);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testBuildBadClass()
    {
        ConfigBuilder::build('WRONGCLASS', new \ArrayObject());
    }
}
