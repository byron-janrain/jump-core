<?php
namespace janrain\plex;

class FeatureStack extends \SPLPriorityQueue
{
	protected $names;

	public function pushFeature(AbstractFeature $f)
	{
		$this->insert($f, $f->getPriority());
		$this->names[$f->getName] = $f;
	}

	public function compare($priority1, $priority2)
	{
		return parent::compare($priority2, $priority1);
	}

	public function getFeature($name)
	{
		return $this->names[$name];
	}
}
