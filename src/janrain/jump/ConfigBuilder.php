<?php
namespace janrain\jump;

class ConfigBuilder
{
    public static function build($featureClassName, \ArrayAccess $data)
    {
        $configName = $featureClassName . 'Config';
        if (!is_subclass_of($configName, 'janrain\jump\AbstractConfig')) {
            throw new \InvalidArgumentException("{$featureClassName} doesn't extend AbstractConfig");
        }
        static $generators = array();
        if (empty($generators[$featureClassName])) {
            $generators[$featureClassName] = new \ReflectionClass($configName);
        }
        return $generators[$featureClassName]->newInstance($data);
    }
}
