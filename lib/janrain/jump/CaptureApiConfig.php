<?php
namespace janrain\jump;

class CaptureApiConfig extends AbstractConfig
{
    public static $REQUIRED_KEYS = array('capture.captureServer', 'capture.clientId', 'capture.clientSecret');

    public function __construct($data)
    {
        parent::__construct($data);
    }
}
