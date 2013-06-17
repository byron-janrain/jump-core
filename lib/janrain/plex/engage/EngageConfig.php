<?php
namespace janrain\plex\engage;

use janrain\jump\AbstractConfig;

class EngageConfig extends AbstractConfig
{

	public static $REQUIRED_KEYS = array('tokenUrl', 'appId', 'appUrl', 'loadJsUrl');

	public function __construct($data)
	{
		parent::__construct($data);
	}
}
