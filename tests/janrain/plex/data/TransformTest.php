<?php
namespace janrain\plex\data;

use janrain\jump\User as Jumper;
use janrain\plex\User as Plexer;

class TransformTest extends \PHPUnit_Framework_TestCase
{


    public function testAssignFromJumpMapping()
    {
        $uuid = `uuidgen`;
        $jumper = Jumper::__set_state(['uuid'=>$uuid]);
        $plexer = $this->getMock(Plexer::class);
        $plexer->expects($this->once())
            ->method('offsetSet')
            ->with($this->equalTo('jump_id'), $this->equalTo($uuid));
        $plexer->expects($this->once())
            ->method('offsetGet')
            ->will($this->returnValue($uuid));

        $map = new AssignFromJump('uuid', 'jump_id');

        #maps always assume jumper, plexer
        $map($jumper, $plexer);

        $this->assertEquals($jumper['uuid'], $plexer['jump_id']);

    }
}
