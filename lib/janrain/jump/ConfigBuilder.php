<?php
namespace janrain\jump;

class ConfigBuilder
{
	public static function build($className, $data)
	{
		static $generators = array();
		if (empty($generators[$className])) {
			$generators[$className] = new \ReflectionClass("{$className}Config");
		}
		return $generators[$className]->newInstance($data);
	}
}
