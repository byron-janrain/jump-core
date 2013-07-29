<?php
namespace janrain\plex;

use \janrain\jump\User as Jumper;

interface Platform
{
    /**
     * Return configuration data from this platform.
     *
     * @return ArrayAccess
     */
    public function getConfig();

    public function getLocale();

    public function fetchPlexerForJumper(Jumper $j);
}
