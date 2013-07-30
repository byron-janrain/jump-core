<?php
namespace janrain\jump\data;

use janrain\jump\User as Jumper;
use janrain\plex\User as Plexer;

abstract class TransformPlexer implements Plexer {
    public function offsetSet($name, $value)
    {
        $this->name = $value;
    }
    public function offsetGet($name)
    {
        return isset($this->name) ? $this->name : null;
    }
}

class TransformTest extends \PHPUnit_Framework_TestCase
{
    protected $uuid;
    protected $jumper;
    protected $plexer;

    public function setUp()
    {
        $this->jumper = Jumper::__set_state(['uuid' => `uuidgen`]);
        $this->plexer = $this->getMockForAbstractClass(TransformPlexer::class);
    }

    public function testBuildMapping()
    {
        $xform = new Transform();
        $xform->addOp(new AssignFromJump('/uuid', 'jump_id'));
        $ops = $xform->getOps();
        $this->assertInstanceOf(\ArrayIterator::class, $ops);
        foreach ($ops as $op) {
            $this->assertInstanceOf(TransformOp::class, $op);
        }
        return $xform;
    }

    /**
     * @depends testBuildMapping
     */
    public function testMapping($xform)
    {
        $this->assertNotEquals($this->jumper->getAttribute('/uuid'), $this->plexer->offsetGet('jump_id'));
        $xform->map($this->jumper, $this->plexer);
        $this->assertEquals($this->jumper->getAttribute('/uuid'), $this->plexer->offsetGet('jump_id'));
    }

    public function testBuildMappingFromJson()
    {
        $json = '[{"op":"AssignFromJump","j":"jf","p":"pf"},{"op":"AssignFromJump","j":"jf2","p":"pf2"}]';
        $xform = Transform::loadFromJson($json);
        $this->assertEquals(2, count($xform->getOps()));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidMappingFromJson()
    {
        $json = '[{"op":"AssignFromJumper","j":"jf","p":"pf"},{"op":"AssignFromJump","j":"jf2","p":"pf2"}]';
        $xform = Transform::loadFromJson($json);
    }
}
