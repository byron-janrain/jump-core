<?php
namespace janrain\plex;

interface ApiSupport
{
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
