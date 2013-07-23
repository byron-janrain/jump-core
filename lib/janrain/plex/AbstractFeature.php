<?php
namespace janrain\plex;

use janrain\jump\AbstractConfig;

abstract class AbstractFeature
{
    protected $config;

    public function __construct(AbstractConfig $c)
    {
        $this->config = $c;
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
}
