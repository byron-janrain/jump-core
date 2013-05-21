<?php
spl_autoload_register(
	function ($className) {
		if ('janrain' == strstr($className, '\\', true)) {
			$className = str_replace('\\', '/', $className);
			require_once dirname(dirname(__DIR__)) . "/{$className}.php";
		}
	}, true, true);
