<?php
namespace janrain\plex;

interface Platform
{
    public function getConfig();

    public function getLocale();

    public function fetchPlexerForJumper(Jumper $j);
}
