<?php
namespace janrain\plex;

interface UserSupport
{
    public function fetchPlexUser(Jumper $j);
    public function loginPlexUser(Plexer $p);
    public function registerJumpUser(Jumper $j);
}
