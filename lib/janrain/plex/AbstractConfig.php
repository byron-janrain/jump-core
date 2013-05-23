<?php
namespace janrain\plex;

use \ArrayObject;
/**
 * @abstract
 * A plex config partial implementation that requires the necessary interfaces and provides
 * a constructor that checks for necessary keys.  Subclasses need only pass a required params
 * array to parent::__construct to validate check for option existence.
 */
abstract class AbstractConfig extends ArrayObject implements ConfigInterface
{
	public function __construct(Array $data, Array &$required)
	{
		foreach ($required as &$key) {
			if (array_key_exists($key, $data)) {
				$this[$key] = $data[$key];
			} else {
				throw new \InvalidArgumentException("Required config {$key} not found!");
			}
		}
	}
}
