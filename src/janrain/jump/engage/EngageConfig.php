<?php
namespace janrain\jump\engage;

use janrain\jump\AbstractConfig;
use janrain\plex\Config;


class EngageConfig extends AbstractConfig
{

    public static $REQUIRED_KEYS = array(
        'tokenUrl', 'appId', 'appUrl', 'loadJsUrl');

    public function __construct(Config $data)
    {
        parent::__construct($data);
    }
}
