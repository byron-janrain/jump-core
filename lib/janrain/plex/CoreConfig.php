<?php
namespace janrain\plex;

use janrain\jump\AbstractConfig;

class CoreConfig extends AbstractConfig
{
	public static $REQUIRED_KEYS = array('jumpUrl');

	public function __construct($data)
	{
		parent::__construct($data);
	}
}