<?php
namespace janrain\plex;

use janrain\jump\User as Jumper;
use janrain\plex\User as Plexer;

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

    public function loginPlexer(Plexer $p);


    /**
     * This allows the API to make calls to Janrain using the transport mechanisms of the platform
     * should one be missing, the API generic feature should return a callable which implements a
     * "universal" caller based on stream contexts.
     *
     * @param string url
     *   The full URL of the remote request.
     *
     * @param string postBody
     *   The body of the post (we're always using post, right?)
     *
     * @param Array headers
     *   An array of headers e.g. ['Content-type' => 'application/x-www-form-urlencoded']
     *
     * @return mixed
     */
    public function httpPost($url, $postBody, Array $headers);
}
