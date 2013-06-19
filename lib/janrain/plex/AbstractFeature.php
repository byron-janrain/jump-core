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

	public function getName()
	{
		return substr(strrchr(get_class($this), '\\'), 1);
	}

	abstract public function getPriority();
}
