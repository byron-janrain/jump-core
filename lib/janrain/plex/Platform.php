<?php
namespace janrain\plex;

use \janrain\jump\User as Jumper;

interface Platform
{
    public function getConfig();

    public function getLocale();

    public function fetchPlexerForJumper(Jumper $j);
}
