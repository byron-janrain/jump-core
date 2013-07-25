<?php
namespace janrain\jump;

class ConfigBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $config = ConfigBuilder::build('janrain\plex\core\Core', new \ArrayObject(['features' => [], 'jumpUrl' => '']));
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
