<?php
namespace janrain\jump;

class ConfigBuilder
{
	public static function build($className, $data)
	{
		if (!is_subclass_of($className, 'janrain\jump\AbstractConfig')) {
			throw new \InvalidArgumentException("{$className} doesn't extend AbstractConfig");
		}
		static $generators = array();
		if (empty($generators[$className])) {
			$generators[$className] = new \ReflectionClass("{$className}Config");
		}
		return $generators[$className]->newInstance($data);
	}
}
