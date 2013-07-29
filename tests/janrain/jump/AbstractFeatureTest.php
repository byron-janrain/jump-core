<?php
namespace janrain\jump;

class AbstractFeatureTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInitNoConfig()
    {
        $mock = $this->getMockForAbstractClass(AbstractFeature::class);
    }

    public function testInit()
    {
        $mockConf = $this->getMockForAbstractClass(AbstractConfig::class, array(), '', false);
        $mock = $this->getMockForAbstractClass(AbstractFeature::class, array($mockConf));
        $this->assertInstanceOf(AbstractFeature::class, $mock);
        return $mock;
    }

    /**
     * @depends testInit
     */
    public function testIsEnabled(AbstractFeature $mock)
    {
        $this->assertEquals(true, $mock->isEnabled());
    }

    /**
     * @depends testInit
     */
    public function testGetName(AbstractFeature $mock)
    {
        $rc = new \ReflectionClass($mock);
        $this->assertEquals($rc->getShortName(), $mock->getName());
    }
}
