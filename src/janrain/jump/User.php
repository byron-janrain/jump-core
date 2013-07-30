<?php
namespace janrain\jump;

use janrain\jump\data\Transformable;

class User implements Transformable
{

    protected $data;
    protected $dataKeys;

    public function getAttribute($path)
    {
        if ($this->hasAttribute($path)) {
            return $this->dataKeys[$path];
        }
        return null;
    }

    public function setAttribute($path, $value)
    {
        if ($this->hasAttribute($path)) {
            $this->dataKeys[$path] = $value;
        }
    }

    public function hasAttribute($path)
    {
        return isset($this->dataKeys[$path]);
    }

    public function getAttributePaths()
    {
        return array_keys($this->dataKeys);
    }

    private function mapAttributes(&$data, $lastKey = '')
    {
        foreach ($data as $k => &$v) {
            if (is_numeric($k)) {
                $key = $lastKey . '#' . (intval($k) + 1);
            } else {
                $key = $lastKey . '/' . $k;
            }
            $this->dataKeys[$key] = &$v;
            if (is_array($v)) {
                $this->mapAttributes($v, $key);
            }
        }
    }

    public static function __set_state(Array $data)
    {
        if (empty($data['uuid'])) {
            throw new \InvalidArgumentException();
        }
        $instance = unserialize(sprintf('O:%u:"%s":0:{}', strlen(__CLASS__), __CLASS__));
        $instance->data = $data;
        $instance->mapAttributes($instance->data);
        return $instance;
    }
}
