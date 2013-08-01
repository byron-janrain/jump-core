<?php
namespace janrain\jump;

abstract class AbstractFeature
{
    protected $config;
    protected $stack;

    public function __construct(AbstractConfig $c, FeatureStack $fs)
    {
        $this->config = $c;
        $this->stack = $fs;
    }

    public function isEnabled()
    {
        return true;
    }

    public function getName()
    {
        $class = get_called_class();
        if (strpos($class, '\\') === false) {
            return $class;
        }
        return substr(strrchr(get_called_class(), '\\'), 1);
    }

    abstract public function getPriority();

    public function setConfigItem($key, $value)
    {
        return $this->config->offsetSet($key, $value);
    }

    public function getStack()
    {
        return $this->stack;
    }
}
