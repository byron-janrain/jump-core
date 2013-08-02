<?php
namespace janrain\jump;

use janrain\plex\Config;

class ConfigBuilder
{
    public static function build($featureClassName, Config $plexConf)
    {
        static $generators = array();
        $configName = $featureClassName . 'Config';
        if (!is_subclass_of($configName, 'janrain\jump\AbstractConfig')) {
            throw new \InvalidArgumentException("{$featureClassName} doesn't extend AbstractConfig");
        }
        if (empty($generators[$featureClassName])) {
            $generators[$featureClassName] = new \ReflectionClass($configName);
        }
        return $generators[$featureClassName]->newInstance($plexConf);
    }
}
