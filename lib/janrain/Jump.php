<?php
namespace janrain;

use SPLPriorityQueue;
use janrain\jump\ConfigBuilder;
use janrain\plex\AbstractFeature;
use UnexpectedValueException;

final class Jump
{
	private $features;
	private $featureNames;

	private function __construct($data)
	{
		$this->features = new SPLPriorityQueue();
		$this->featureNames = array();
		$featureList = $data['features'];
		foreach ($featureList as $fName) {
			$fClass = '\\janrain\\plex\\' . strtolower($fName) . "\\$fName";
			$fConfig = ConfigBuilder::build($fClass, $data);
			if (!class_exists($fClass)) {
				throw new UnexpectedValueException("Failed to load class {$fClass}");
			}
			$feature = new $fClass($fConfig);
			$this->pushFeature($feature);
		}
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
