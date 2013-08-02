<?php
namespace janrain\jump;

use janrain\plex\Config;

/**
 * Configuration handler template class.
 *
 * Extenders of this class _may_ define a static $REQUIRED_KEYS property with the key names
 * of values they depend on.
 *
 * Additionally, extenders may implement mutators that will be automatically called when
 * values are assigned to keys.
 *
 * @todo Create a generic subclass for testing this explicitly
 */
abstract class AbstractConfig implements \ArrayAccess, \IteratorAggregate
{
    protected $plexConf;

    public static $REQUIRED_KEYS = array();

    public function __construct(Config $plexConf)
    {
        $this->plexConf = $plexConf;
        foreach (static::$REQUIRED_KEYS as $key) {
            if (!$this->offsetExists($key)) {
                throw new \InvalidArgumentException("Required key \"$key\" not found when instantiating " . get_class($this));
            }
        }
    }

    public function getIterator()
    {
        return $this->plexConf->getIterator();
    }

    public function offsetExists($offset)
    {
        return (bool) !is_null($this->plexConf->getItem($offset));
    }

    public function offsetGet($offset)
    {
        return $this->plexConf->getItem($offset) ?: null;
    }

    public function offsetUnset($offset)
    {
        $this->plexConf->setItem($offset, null);
    }

    public function offsetSet($offset, $value)
    {
        $methodName = 'set' . $this->camelfy($offset);
        if (method_exists($this, $methodName)) {
            #an explicit setter exists, so use it
            return $this->$methodName($value);
        } elseif (method_exists($this, '__set')) {
            #no explicit setter exists, but an implied magic setter does
            return $this->__set($offset, $value);
        } else {
            #nothing special happening here, so proceed as normal.
            $this->plexConf->setItem($offset, $value);
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
                $val = ucfirst(strtolower($val));
            });
        return implode('', $strings);
    }

    /*
    protected function flatten($jsonDecoded, $path = '', &$out = array())
    {
        $type = gettype($jsonDecoded);

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
    */

    /**
    * @todo implement this as a reconstruction base on the values
    */
    public function __toString() {
        return $this->plexConf->toJson();
    }
}
