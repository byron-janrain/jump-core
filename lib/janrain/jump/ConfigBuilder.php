<?php
namespace janrain\jump;

class ConfigBuilder
{
	public static function build($data, $returnType)
	{
		static $generators = array();
		if (empty($generators[$returnType])) {
			$generators[$returnType] = new ReflectionClass("{$returnType}Config");
		}
		return $generators[$returnType]->newInstance($data);
	}
}
