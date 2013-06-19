<?php
namespace janrain;

use SPLPriorityQueue;
use janrain\jump\ConfigBuilder;
use janrain\plex\AbstractFeature;
use UnexpectedValueException;
use janrain\plex\Core;

final class Jump implements plex\RenderableInterface
{
	private $features;
	private $featureNames;

	private function __construct($data)
	{
		$this->features = new SPLPriorityQueue();
		$coreConfig = ConfigBuilder::build('janrain\\plex\\Core', $data);
		$core = new Core($coreConfig);
		$this->pushFeature($core);
		foreach ($data['features'] as $fName) {
			$fClass = '\\janrain\\plex\\' . strtolower($fName) . "\\$fName";
			$fConfig = ConfigBuilder::build($fClass, $data);
			if (!class_exists($fClass)) {
				throw new UnexpectedValueException("Failed to load class {$fClass}");
			}
			$feature = new $fClass($fConfig);
			$this->pushFeature($feature);
		}
	}


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

	public function getFeature($name)
	{
		return $this->features[$name];
	}

	private function pushFeature(AbstractFeature $f)
	{
		$this->featureNames[$f->getName()] = $f;
		$this->features->insert($f, $f->getPriority());
	}

	private static $instance;
	public static function getInstance($data)
	{
		if (empty(self::$instance)) {
			self::$instance = new self($data);
		}
		return self::$instance;
	}
}
