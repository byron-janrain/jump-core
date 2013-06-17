<?php
namespace janrain\plex;

use janrain\jump\AbstractConfig;

abstract class AbstractFeature
{
	protected $config;

	public function __construct(AbstractConfig $c)
	{
		$this->config = $c;
	}

	public function isEnabled()
	{
		return true;
	}
}
