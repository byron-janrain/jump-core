<?php
namespace janrain\jump;

use \ArrayAccess;
use \IteratorAggregate;
use \Countable;
use \ArrayObject;

/**
 * Configuration handler template class.
 *
 * Extenders of this class _may_ define a static $REQUIRED_KEYS property with the key names
 * of values they depend on.
 *
 * Additionally, extenders may implement mutators that will be automatically called when
 * values are assigned to keys.
 */
abstract class AbstractConfig implements ArrayAccess, IteratorAggregate, Countable
{
	protected $arrayObj;

	public static $REQUIRED_KEYS = array();

	public function __construct($data)
	{
		$data = $this->flatten($data);
		$this->arrayObj = new ArrayObject($data, ArrayObject::ARRAY_AS_PROPS);
		foreach (static::$REQUIRED_KEYS as &$key) {
			if (!$this->arrayObj->offsetExists($key)) {
				throw new \InvalidArgumentException("Required key \"$key\" not found when instantiating " . get_class());
			}
		}
	}

	public function count() {return $this->arrayObj->count();}

	public function getIterator() {return $this->arrayObj->getIterator();}

	public function offsetExists($offset) {return $this->arrayObj->offsetExists($offset);}
	public function offsetGet($offset) {return $this->arrayObj->offsetExists($offset) ? $this->arrayObj->offsetGet($offset) : null;}
	public function offsetUnset($offset) {return $this->arrayObj->offsetUnset($offset);}

	public function offsetSet($offset, $value)
	{
		$methodName = 'set' . ucfirst($offset);
		if (method_exists($this, $methodName)) {
			#an explicit setter exists, so use it
			return $this->$methodName($value);
		} elseif (method_exists($this, '__set')) {
			#no explicit setter exists, but an implied magic setter does
			return $this->__set($offset, $value);
		} else {
			#nothing special happening here, so proceed as normal.
			return $this->arrayObj->offsetSet($offset, $value);
		}
	}

	/**
	* @todo create naming convention for complex keys
	*/
	private function camelfy($string)
	{
		$strings = preg_split('|\\W|', $string, null, PREG_SPLIT_NO_EMPTY);
		array_walk($strings,
			function (&$val, $key) {
				$val = ucfirststrtolower($val);
			});
	}
	protected function flatten($jsonDecoded, $path = '', &$out = array())
	{
		$type = gettype($jsonDecoded);

		#sanity check
		if ('' == $path && 'array' == $type) {
			throw new \InvalidArgumentException("Tsk tsk, config data must have keys!");
		}

		if ('object' != $type) {
			$out[$path] = $jsonDecoded;
		} else {
			foreach ($jsonDecoded as $k => $v) {
				$newPath = '';
				if ('object' == $type) {
					$newPath = $path ? "{$path}->{$k}" : $k;
				}
				$this->flatten($v, $newPath, $out);
			}
		}
		return $out;
	}

	/**
	* @todo implement this as a reconstruction base on the values
	*/
	public function __toString() {
		return json_encode($this);
	}
}
