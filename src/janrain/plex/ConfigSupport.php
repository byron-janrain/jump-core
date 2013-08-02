<?php
namespace janrain\plex;

interface ConfigSupport
{
    /**
     * Return configuration data from this platform.
     *
     * @return janrain\plex\Config
     */
    public function getConfig();
}
