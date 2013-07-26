<?php
return new \Sami\Sami(
    './lib',
    [
        'build_dir' => __DIR__ . '/docs',
        'cache_dir' => __DIR__ . '/docs/cache',
        'default_opened_level' => 10,
        'theme' => 'enhanced'
    ]);
