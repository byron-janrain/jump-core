<?php
namespace janrain\jump\data\ops;

use janrain\jump\User as Jumper;
use janrain\plex\User as Plexer;
use janrain\jump\data\TransformOp;

class AssignFromJump extends TransformOp
{
    public function __invoke(Jumper $j, Plexer $p)
    {
        $p->setAttribute($this->destName, $j->getAttribute($this->srcName));
    }
}
