<?php
#psr0 loader for builds
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__DIR__) . '/src');
spl_autoload_register();
