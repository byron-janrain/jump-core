<?php
namespace janrain;

use janrain\plex\Core;

final class Jump implements plex\RenderableInterface
{
	private $features;


	/**
	 * {@inheritdoc}
	 */
	public function getHeadJsSrcs()
	{
		$out = array();
		foreach ($this->features as $f) {
			$out = array_merge($out, $f->getHeadJsSrcs());
		}
		return $out;
	}

	public function getStartHeadJs() {
		$out = '';
		foreach ($this->features as $f) {
			$out .= $f->getStartheadJs();
		}
		return $out;
	}

	public function getSettingsHeadJs() {
		$out = '';
		foreach ($this->features as $f) {
			$out .= $f->getSettingsHeadJs();
		}
		return $out;
	}

	public function getEndHeadJs() {
		$out = '';
		foreach ($this->features as $f) {
			$out .= $f->getEndHeadJs();
		}
		return $out;
	}
	public function getCssHrefs() {
		$out = array();
		foreach ($this->features as $f) {
			$out = array_merge($out, $f->getCssHrefs());
		}
		return $out;
	}
	public function getCss() {
		$out = '';
		foreach ($this->features as $f) {
			$out .= $f->getCss();
		}
		return $out;
	}
	public function getHtml() {
		return '';
	}

	public function raw_render()
	{
		$out = "//START Janrain JUMP\n";
		foreach ($this->getCssHrefs() as $href) {
			$out .= "<link type='text/css' rel='stylesheet' href='{$href}'/>\n";
		}
		$out .= "<style type='text/css'>\n{$this->getCss()}\n</style>\n";
		foreach ($this->getHeadJsSrcs() as $src) {
			$out .= "<script type='text/javascript' src='{$src}'></script>\n";
		}
		$out .= "<script type='text/javascript><![CDATA[\n{$this->getStartheadJs()}\n{$this->getSettingsHeadJs()}\n{$this->getEndHeadJs()}\n]]></script>";
		$out .= "//END Janrain JUMP\n";
		return $out;
	}

	public function getFeatures()
	{
		return $this->features;
	}

	public function getFeature($name)
	{
		return $this->features->getFeature($name);
	}

	public function init($data)
	{
		$coreConfig = jump\ConfigBuilder::build('janrain\\plex\\Core', $data);
		$core = new plex\Core($coreConfig);
		$this->features->pushFeature($core);
		foreach ($data['features'] as $fName) {
			$fClass = '\\janrain\\plex\\' . strtolower($fName) . "\\$fName";
			$fConfig = jump\ConfigBuilder::build($fClass, $data);
			if (!class_exists($fClass)) {
				throw new \UnexpectedValueException("Failed to load class {$fClass}");
			}
			$feature = new $fClass($fConfig);
			$this->features->pushFeature($feature);
		}
	}

	private function __construct()
	{
		$this->features = new plex\FeatureStack();
	}
	private static $instance;
	public static function getInstance()
	{
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}
