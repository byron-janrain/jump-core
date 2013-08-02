<?php
namespace janrain\plex;

use janrain\jump\User as Jumper;
use janrain\plex\User as Plexer;

interface Platform
{
    public function fetchPlexUser(Jumper $j);
    public function loginPlexUser(Plexer $p);
    public function registerJumpUser(Jumper $j);
}
