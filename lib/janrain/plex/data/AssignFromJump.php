<?php
namespace janrain\plex\data;

use janrain\jump\User as Jumper;
use janrain\plex\User as Plexer;

class AssignFromJump {

    protected $src;
    protected $dest;

    public function __construct($srcField, $destField)
    {
        $this->src = $srcField;
        $this->dest = $destField;
    }

    public function __invoke(Jumper $j, Plexer $p)
    {
        $p[$this->dest] = $j[$this->src];
    }
}
