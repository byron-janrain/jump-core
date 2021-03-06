<?php
namespace janrain\jump\data;

class TransformOpTest extends \PHPUnit_Framework_TestCase
{
    protected $mock;

    public function setUp()
    {
        $this->mock = $this->getMockForAbstractClass(
            __NAMESPACE__ . '\\TransformOp',
            array('jumpField', 'plexField'));
    }

    public function testToString()
    {
        $opName = get_class($this->mock);
        $serialized = $this->mock->__toString();
        $this->assertEquals(sprintf('{"op":"%s","j":"jumpField","p":"plexField"}', $opName), $serialized);
    }
}
