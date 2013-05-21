<?php
namespace janrain\plex;

interface ConfigInterface extends \ArrayAccess
{
	public static function getRequiredKeys();
}
