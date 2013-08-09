<?php
namespace janrain\jump;

use janrain\plex\GenericConfig;

class ConfigSetterImpl extends AbstractConfig
{
    public function setKey1($value)
    {
        $this->plexConf->setItem('key1', 'setter' . $value);
    }
}

class ConfigMagicSetterImpl extends AbstractConfig
{
    public function __set($key, $value)
    {
        $this->plexConf->setItem($key, 'magic' . $value);
    }
}

class ConfigSetterAndMagic extends AbstractConfig
{
    public function setKey1($value)
    {
        $this->plexConf->setItem('key1', 'setter' . $value);
    }

    public function __set($key, $value)
    {
        $this->plexConf->setItem($key, 'magic' . $value);
    }
}

class AbstractConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testInit()
    {
        $mock = $this->getMockForAbstractClass(
            __NAMESPACE__ . '\\' . 'AbstractConfig',
            array(new GenericConfig(array('key1' => 'value1'))));
        $mock->expects($this->any())
            ->method('setKey1')
            ->will($this->returnValue(null));
        return $mock;
    }

    /**
     * @depends testInit
     */
    public function testCount($mock)
    {
        $this->assertEquals(1, count($mock));
    }

    /**
     * @depends testInit
     */
    public function testGetIterator($mock)
    {
        $this->assertInstanceOf('Traversable', $mock->getIterator());
    }

    /**
     * @depends testInit
     */
    public function testOffsetGetReturnsNullForMissingKey($mock)
    {
        $out = $mock['nokey'];
        $this->assertEquals(null, $out);
    }

    /**
     * @depends testInit
     */
    public function testOffsetGet($mock)
    {
        $this->assertEquals('value1', $mock['key1']);
    }

    /**
     * @depends testInit
     */
    public function testOffsetUnset($mock)
    {
        unset($mock['key1']);
        $this->assertEquals(null, $mock['key1']);
    }

    /**
     * @depends testInit
     */
    public function testOffsetSet($mock)
    {
        $mock->offsetSet('key1', 'value1');
        $this->assertEquals('value1', $mock['key1']);
    }

    public function testSetter()
    {
        $conf = new ConfigSetterImpl(new GenericConfig());
        $conf['key1'] = 'value2';
        $this->assertEquals('settervalue2', $conf['key1']);
    }

    public function testMagicSetter()
    {
        $conf = new ConfigMagicSetterImpl(new GenericConfig());
        $conf['key3'] = 'value2';
        $this->assertEquals('magicvalue2', $conf['key3']);
    }

    public function testSetterBeforeMagic()
    {
        $conf = new ConfigSetterAndMagic(new GenericConfig());
        $conf['key1'] = 'value1';
        $this->assertEquals('settervalue1', $conf['key1']);
    }

    /**
     * @depends testInit
     */
    public function testToJson($mock)
    {
        $mock['key1'] = 'value1';
        $this->assertEquals('{"key1":"value1"}', $mock->__toString());
    }
}
