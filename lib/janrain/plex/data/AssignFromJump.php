<?php
namespace janrain\plex\data;

use janrain\jump\User as Jumper;
use janrain\plex\User as Plexer;

class AssignFromJump extends TransformOp
{
    public function __invoke(Jumper $j, Plexer $p)
    {
        $p->offsetSet($this->destName, $j->offsetGet($this->srcName));
    }
}
