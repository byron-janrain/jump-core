<?php
namespace janrain\plex;

use \janrain\jump\User as Jumper;

interface Platform
{
    /**
     * Return configuration data from this platform.
     *
     * @return janrain\jump\AbstractConfig
     */
    public function getConfig();

    public function getLocale();

    public function fetchPlexerForJumper(Jumper $j);

    public function registerJumper(Jumper $j);

    public function loginJumper(Jumper $j);
}
