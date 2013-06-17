<?php
namespace janrain\plex\capture;

use janrain\jump\AbstractConfig;

class CaptureConfig extends AbstractConfig
{

	public static $REQUIRED_KEYS = array('capture.appId', 'capture.clientId', 'capture.captureServer');

	public function __construct($data)
	{
		parent::__construct($data);
	}
}
