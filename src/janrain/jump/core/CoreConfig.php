<?php
namespace janrain\jump\core;

use janrain\jump\AbstractConfig;
use janrain\plex\Config;

class CoreConfig extends AbstractConfig
{
    public static $REQUIRED_KEYS = array('jumpUrl', 'features');

    public function __construct(Config $data)
    {
        parent::__construct($data);
        if ($data->getItem('features')) {
            $data->setItem('features', array('Core'));
        }
    }
}
