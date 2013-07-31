<?php
namespace janrain\jump\captureapi;

use janrain\jump\AbstractConfig;

class CaptureApiConfig extends AbstractConfig
{
    public static $REQUIRED_KEYS = array('capture.captureServer', 'capture.clientId', 'capture.client_secret');

    public function __construct(&$data)
    {
        parent::__construct($data);
    }
}
