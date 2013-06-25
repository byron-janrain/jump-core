<?php
namespace janrain\plex\engage;

use janrain\plex\AbstractFeature;

class Engage extends AbstractFeature
{
	protected $config;

	public function __construct(EngageConfig $c)
	{
		$this->config = $c;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getHeadJsSrcs()
	{
		return array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getStartHeadJs()
	{
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSettingsHeadJs()
	{
		$opts = array(
			"opts.tokenUrl = '{$this->config['tokenUrl']}';",
			"opts.appId = '{$this->config['appId']}';",
			"opts.plex.loadJsUrl = '{$this->config['loadJsUrl']}';",
			"opts.appUrl = '{$this->config['appUrl']}';",
			);
		return implode("\n", $opts) . "\n";
	}

	/**
	 * {@inheritdoc}
	 */
	public function getEndHeadJs()
	{
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCssHrefs()
	{
		return array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCss()
	{
		return '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getHtml()
	{
		return "<a class='janrainEngage' href='#'>Sign-In</a>";
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPriority()
	{
		return 2;
	}
}
