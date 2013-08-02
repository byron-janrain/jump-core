<?php
namespace janrain\plex;

class GenericConfig implements Config {

    protected $a;

    public function __construct(Array $data = null)
    {
        if ($data) {
            $this->a = $data;
        } else {
            $this->a = [];
        }
    }

    public function setItem($key, $value)
    {
        $this->a[$key] = $value;
    }

    public function getItem($key)
    {
        return isset($this->a[$key]) ? $this->a[$key] : null;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->a);
    }

    public function toJson()
    {
        return json_encode($this->a);
    }
}
