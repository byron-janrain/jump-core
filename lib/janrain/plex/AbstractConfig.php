<?php
namespace janrain\plex;
/**
 * 
 */
abstract class AbstractConfig extends \ArrayObject implements ConfigInterface
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
