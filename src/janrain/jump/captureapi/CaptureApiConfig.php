<?php
namespace janrain\jump\captureapi;

use janrain\jump\AbstractConfig;
use janrain\plex\Config;

class CaptureApiConfig extends AbstractConfig
{
    public static $REQUIRED_KEYS = array(
        'capture.captureServer', 'capture.clientId', 'capture.client_secret');

    public function __construct(Config $data)
    {
        parent::__construct($data);
    }
}
