<?php
namespace janrain\jump\capture;

use janrain\jump\AbstractConfig;
use janrain\plex\Config;

class CaptureConfig extends AbstractConfig
{

    public static $REQUIRED_KEYS = array(
        'capture.appId', 'capture.clientId', 'capture.captureServer', 'capture.enabled');

    public function __construct(Config $data)
    {
        parent::__construct($data);
    }
}
