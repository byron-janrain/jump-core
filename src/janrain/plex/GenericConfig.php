<?php
namespace janrain\plex;

/**
 * Generic Array-based implementation of the config interface for unit tests and a base for
 * platforms without object-oriented configuration.
 */
class GenericConfig implements Config {

    protected $a;

    /**
     * Build a GenericConfig object from a plain old array.
     *
     * Copies the input array or allocates a new one if none provided.
     *
     * @param Array|null $data The data set to copy.
     */
    public function __construct(Array $data = null)
    {
        if ($data) {
            $this->a = $data;
        } else {
            $this->a = array();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setItem($key, $value)
    {
        $this->a[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getItem($key)
    {
        return isset($this->a[$key]) ? $this->a[$key] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->a);
    }

    /**
     * {@inheritdoc}
     */
    public function toJson()
    {
        return json_encode($this->a);
    }
}
