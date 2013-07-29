<?php
namespace janrain\jump\core;

use janrain\jump\AbstractConfig;

class CoreConfig extends AbstractConfig
{
    public static $REQUIRED_KEYS = array('jumpUrl', 'features');

    public function __construct($data)
    {
        parent::__construct($data);
        if (empty($data['features'])) {
            $data['features'] = array('Core');
        }
    }
}
