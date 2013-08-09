<?php
namespace janrain\jump;

use janrain\plex\GenericConfig;

class AbstractFeatureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testInitNoConfig()
    {
        $mock = $this->getMockForAbstractClass(__NAMESPACE__ . '\\AbstractFeature');
    }

    public function testInit()
    {
        $mockConf = $this->getMockBuilder(__NAMESPACE__ . '\\core\\CoreConfig')
            ->disableOriginalConstructor()->getMock();
        $mockConf->expects($this->any())
            ->method('offsetSet')
            ->with($this->equalTo('key'), $this->equalTo('value'));
        $mockStack = $this->getMock(__NAMESPACE__ . '\\FeatureStack');
        $mock = $this->getMockForAbstractClass(__NAMESPACE__ . '\\AbstractFeature', array($mockConf, $mockStack));
        $this->assertInstanceOf(__NAMESPACE__ . '\\AbstractFeature', $mock);
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

    /**
     * @depends testInit
     */
    public function testGetStack(AbstractFeature $mock)
    {
        $this->assertInstanceOf(__NAMESPACE__ . '\\FeatureStack', $mock->getStack());
    }

    /**
     * @depends testInit
     */
    public function testSetConfig(AbstractFeature $mock)
    {
        $mock->setConfigItem('key', 'value');
    }
}
