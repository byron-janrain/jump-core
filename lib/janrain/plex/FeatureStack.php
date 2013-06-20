<?php
namespace janrain\plex;

class FeatureStack implements \IteratorAggregate
{
	protected $names;
	protected $features;
	protected $iter;

	public function pushFeature(AbstractFeature $f)
	{
		$this->features[$f->getPriority()] = $f;
		$this->names[$f->getName()] = $f;
		$this->iter = new \ArrayIterator($this->features);
	}

	public function getFeature($name)
	{
		return $this->names[$name];
	}

	public function getIterator()
	{
		return $this->iter;
	}
}
