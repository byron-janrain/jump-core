<?php
namespace janrain\plex;
/**
 * 
 */
abstract class AbstractConfig extends \ArrayObject implements ConfigInterface
{
	public function __construct(Array $data, Array $required)
	{
		foreach ($required as $key) {
			if (array_key_exists($key, $data)) {
				$this[$required] = $data[$required];				
			} else {
				throw new \InvalidArgumentException("Required config {$key} not found!");
			}
		}
	}
}
